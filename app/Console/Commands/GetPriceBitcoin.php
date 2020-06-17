<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
Use App\Bitcoin_quote;
 

class GetPriceBitcoin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'GetPriceBitcoin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'GetPriceBitcoin:get';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $date = date('Y-m-d H:i:s',strtotime('-90 days ',strtotime(date("Y-m-d H:m:s"))));
        $history  = Bitcoin_quote::whereDate('created_at','<=',$date)->delete();

        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', env('PATH_API'));
        $response->getHeaderLine('content-type');
        $data = json_decode($response->getBody(),true); 

        $btc = new Bitcoin_quote;
        $btc->quote =  $data['ticker']['buy'];
        if($btc->save()){
            echo "Price saved: ".date('Y-m-d h:i');      
        }

       
    }
}