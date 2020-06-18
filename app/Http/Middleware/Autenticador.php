<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Firebase\JWT\JWT;

class Autenticador
{
 
   public function handle($request, Closure $next)
   {
    try{
 
        if (!$request->hasHeader('Authorization')) {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException();
        }
        $authorizationHeader = $request->header('Authorization');
        $token = str_replace('Bearer ', '', $authorizationHeader);
             try {
                  $dadosAutenticacao = JWT::decode($token, env('JWT_KEY'), ['HS256']);      
             } catch (\Exception $e) {
                   return response()->json(['message' => 'Seu token é invalido'],204);
             }

        $user =  User::where('email', $dadosAutenticacao->email)->first();
        if(is_null($user)){
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException();
        } 
        return $next($request);

     } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
         return response()->json('Unauthorized',401);
     }   
   }
   
}
