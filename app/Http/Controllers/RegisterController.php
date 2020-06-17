<?php

namespace App\Http\Controllers;

use App\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;

use App\Mail\WellcomeMail;

class RegisterController extends Controller
{

   public function teste(){
       $user = User::where('email','thiagomarcato@gmail.com')->first();
      
    }

    public function register_form(){
        return view('register');
    }
    public function store(Request $request){

        $this->validate($request, [
            'name'    => 'required',
            'email'   => 'required',
            'password'=> 'required',
            'password' => 'required|min:6|'
            //'password_confirmation' => 'required|min:6'
        ]);
        $email = $request->email;
 
        $user = User::where('email',$email)->first();

        if(!$user){
            $user = new User();
            $user->email = $email;
            $user->name = $request->name;
            $user->password = Hash::make($request->password);
            if($user->save()){
                Mail::to($user->email)->send(new WellcomeMail($user));
                return response()->json('Created', 201);
            }
        }else{
            return response()->json('Account Already Exists', 400);
        }
 

    }

    public function login_form(){
        return view('login');
    }

}
