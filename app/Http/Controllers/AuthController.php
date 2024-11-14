<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request){
        $fields = $request->validate([
            "name"=> 'required|max:255',
            "email"=> 'required|email|unique:users',
            'password'=> 'required|confirmed'
        ]);

        $user = User::create($fields);
        $token = $user->createToken($request->email);
        return response()->json([
            'user'=>$user,
            'token'=>$token->plainTextToken
        ]);
    }

    public function login(Request $request){
        $fields = $request->validate([
            'email'=>'required|email|exists:users,email',
            'password'=>'required'
        ]);

        $user = User::where('email',$request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                'message'=> 'the provided credentials are incorrect!'
            ]);
        }

        $token = $user->createToken($request->email);
        
        return response()->json([
            'user'=>$user,
            'token'=>$token->plainTextToken
        ]);
    }

    public function logout(Request $request){
        $request->user()->tokens()->delete();

        return response()->json([
            'message'=> 'You are logged out!'
        ]);
    }
}
