<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\User;

class RegisterController extends Controller
{
    public function register(Request $request){

        $this->validate($request,[
            'first_name'=> 'required',
            'last_name'=> 'required',
            'email' => 'required|email|unique:users,email',
            'password'=> 'required|string|min:8|regex:/^.*(?=.*[0-9]).*$/|confirmed',
            'password_confirmation' => 'required',
            'terms_and_conditions' => 'required'
        ]);

        // if($validator->fails()){
        //     return response()->json($validator->errors()->toJson(),400);
        // }

        $user = User::create([
            'first_name' => $request->first_name,
            'email' => $request->email,
            'last_name' => $request->last_name,
            'password' => bcrypt($request->password),
            'terms_and_conditions' => true,
        ]);

        $token = JWTAuth::fromUser($user);
        return response()->json(compact('user','token'),201);
    }
}
