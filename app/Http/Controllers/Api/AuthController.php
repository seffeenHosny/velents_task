<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Passport\Token;

class AuthController extends Controller
{
    public function login()
    {
        if (auth()->attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = auth()->user();

            $user_token = $user->createToken('MyApp')->accessToken; 

            return message(['user'=>new UserResource($user) , 'token'=>$user_token] , "");
            
        } else {
            // failure to authenticate

            return message([] , "Failed to authenticate." , false , 401);
            
        }
    }

    public function info(){
        return message(['user'=>new UserResource(auth()->user())] , "User Info");
    }

    public function logout(){
        $user = auth()->user();
        $user->token()->revoke();
        return message([] , "User logout");
    }
}
