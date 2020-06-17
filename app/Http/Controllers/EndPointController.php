<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use Firebase\JWT\JWT;
use App\Checking_account;
use App\Bitcoin_quote;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReceivedDeposit;
use App\Mail\BuyBtc;
use App\Mail\SellBtc;

class EndPointController extends Controller
{
 
  private $user;

    public function __construct(Request $request)
    {
      if($request->hasheader('Authorization')){
        $authorizationHeader = $request->header('Authorization');
        $token = str_replace('Bearer ', '', $authorizationHeader);
        $Auth = JWT::decode($token, env('JWT_KEY'), ['HS256']);
        $this->user =  User::where('email', $Auth->email)->first();
      }
    }



   public function index(){
       return view('index');
   }

   public function deposit(Request $request) {
      
       $this->validate($request, [
            'amount' => 'required|regex:/^\d+(\.\d{1,2})?$/|min:0.1|not_in:0'
        ]);

    $transaction = new Checking_account;
    $transaction->user_id = $this->user->id;
    $transaction->transaction_id = 1;
    $transaction->value = $request->amount;

     if($transaction->save()){
         Mail::to($this->user->email)->send(new ReceivedDeposit($transaction));
         return response()->json('OK', 201);
     }else{
         return response()->json('Deposit is fail', 403);
     }

  }


    public function get_balance(){ 
        $credits = Checking_account::where('user_id',$this->user->id)
                                     ->whereIn('transaction_id',[1,5])
                                     ->get();
        $debits  = Checking_account::where('user_id',$this->user->id)
                                     ->whereIn('transaction_id',[3])
                                     ->get();

        return $credits->SUM('value') - $debits->SUM('value');
    }
    public function get_investiments(){
      $credits = Checking_account::where('user_id',$this->user->id)
                                   ->where('position','<>','t')
                                   ->whereIn('transaction_id',[2])
                                   ->get();
      $debits  = Checking_account::where('user_id',$this->user->id)
                                   ->where('position','<>','t')
                                   ->whereIn('transaction_id',[4])
                                   ->get();

      return $credits->SUM('value') - $debits->SUM('value');
  }
    public function balance(){
        $balance = $this->get_balance();        
        return response()->json(['balance' => $balance,'currency'=>'R$'], 201);
    }


  public function get_btc_price(){
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', env('PATH_API'));
        $response->getHeaderLine('content-type');
        $data = json_decode($response->getBody(),true); 
        return [ 'buy' => $data['ticker']['buy'],'sell' => $data['ticker']['sell']];
  }
    public function btc_price(){

       $quote = $this->get_btc_price();
        if($quote){
           return response()->json(['quote' => $quote], 201);
        }else{
            return response()->json('quote unavailable', 403);
        }
    }

  public function btc_purchase(Request $request){
        $this->validate($request, [
            'amount' => 'required|regex:/^\d+(\.\d{1,2})?$/|min:0.1|not_in:0'
        ]);

        $btc_price = $this->get_btc_price()['buy'];


        $balance = $this->get_balance();

        $amount = (float) $request->amount;

        if($amount > $balance){
            return response()->json(['error'=>'insufficient funds','balance'=>$balance], 403);
        }

        $btc_amount = $amount / $btc_price;
        
        $t_credit = new Checking_account;
        $t_credit->user_id = $this->user->id;
        $t_credit->transaction_id = 2;
        $t_credit->value = $btc_amount;
        $t_credit->btc_price = $btc_price;
        $t_credit->position = 'b';
        if($t_credit->save()){
                   $t_debit = new Checking_account;
                   $t_debit->user_id = $this->user->id;
                   $t_debit->transaction_id = 3;
                   $t_debit->value = $amount;
                   $t_debit->save();
                    Mail::to($this->user->email)->send(new BuyBtc($t_credit)); 
                   return response()->json('purchase success', 201);

        }

     
  }

  public function btc_sell(Request $request){

    $this->validate($request, [
        'amount' => 'required|regex:/^\d+(\.\d{1,17})?$/'
    ]);

    $amount = (float) $request->amount;
    $btc_price = $this->get_btc_price()['sell'];
    $balance = $this->get_investiments();
   
    if($amount > $balance){
        return response()->json(['error'=>'insufficient funds','balance'=>$balance], 403);
    }

    $balance_to_sell = floatval($amount); 
    
    $btc_amount = $amount * $btc_price;

    // Get orders available for sale 
    $purchases = $this->to_sell($amount);
 
    foreach($purchases as $purchase){
       if($purchase->value < $balance_to_sell){
          //mark order like sell
          $purchase->position = 's';
       }else{
          //mark order like transfer a partial to new investment
          $purchase->position = 't';
       }
       $purchase->save(); 
       $balance_to_sell -= floatval($purchase->value);
    }
 
    //Generate partial off sell investment
    if($balance_to_sell < 0){
        $partial = new Checking_account;
        $partial->user_id = $this->user->id;
        $partial->transaction_id = 2;
        $partial->value = $balance_to_sell*(-1);
        $partial->btc_price = $purchase->btc_price;
        $partial->position = 'b';
        $partial->save();
    }


    //Generate transfer of values
    $t_credit = new Checking_account;
    $t_credit->user_id = $this->user->id;
    $t_credit->transaction_id = 5;
    $t_credit->value = $btc_amount;
    $t_credit->btc_price = $btc_price;
    if($t_credit->save()){
               $t_debit = new Checking_account;
               $t_debit->user_id = $this->user->id;
               $t_debit->transaction_id = 4;
               $t_debit->value = $amount;
               $t_debit->save();
                Mail::to($this->user->email)->send(new SellBtc($t_credit)); 
               return response()->json('Successful sale', 201);

    }

  
}

public function to_sell($amount){
    //taking the older purchases to sell
    $take = 1;
    do {
    $purchases = Checking_account::where('user_id',$this->user->id)
                                 ->where('position','b')
                                 ->whereIn('transaction_id',[2])
                                 ->orderby('created_at','asc')
                                 ->take($take)
                                 ->get();
        $take ++;
      } while ($purchases->sum('value') < $amount);
    
    return $purchases;
}

public function extract(Request $request){
  $start_at = $request->start_at;
  $end_at = $request->end_at;

  if($start_at){
    $this->validate($request, [
      'start_at'      => 'required|date|date_format:Y-m-d|before:end_at',
      'end_at'        => 'required|date|date_format:Y-m-d|after:start_at'
  ]);
  }

  if(!$start_at) $start_at = date('Y-m-d H:i:s',strtotime('-90 days ',strtotime(date("Y-m-d H:m:s"))));
  if(!$end_at) $end_at = date('Y-m-d H:i');


  $extract  = Checking_account::join('transaction', 'checking_account.transaction_id', '=', 'transaction.id')
              ->where('user_id',$this->user->id)
              ->whereBetween('created_at',[$start_at,$end_at])
              ->where('position','<>','t')
              ->orderby('created_at','desc')
              ->get(['checking_account.id','transaction.description','value','created_at as date','action','currency']);
  return response()->json($extract, 201);

}

public function volume(){
  
  $today = date('Y-m-d');
  $volume  = Checking_account::join('transaction', 'checking_account.transaction_id', '=', 'transaction.id')
               ->selectRaw('description, sum(value) as amount,created_at')
               ->where('user_id',$this->user->id)
               ->where('position','<>','t')
               ->whereIn('transaction_id',[2,4])
               ->whereDate('created_at','>=',$today)
               ->groupBy('transaction_id')
               ->get();

  return response()->json($volume, 201);
}

public function history(){
  $date = date('Y-m-d H:i',strtotime('-24 hour ',strtotime(date("Y-m-d H:m:s"))));
  $history  = Bitcoin_quote::where('created_at','>=',$date)->get();
  return response()->json($history, 201);
 }

public function position(){

    $btc_price = (string) $this->get_btc_price()['buy'];

    $extract  = Checking_account::join('transaction', 'checking_account.transaction_id', '=', 'transaction.id')
              ->where('user_id',$this->user->id)
              ->where('position','b')
              ->where('transaction_id','2')
              ->orderby('created_at','desc')
              ->get(['checking_account.id',
                     'value','created_at as date_investment',
                     'btc_price',DB::raw('round((btc_price * value),2) as investment'),
                      DB::raw('round(('.$btc_price.'/ btc_price -1 )*100,2) as variation_investment')
                  ]);

  return response()->json($extract, 201);
}
}
