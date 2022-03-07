<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class AuthController extends Controller
{
    public function login(Request $request){
        $credentials = $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);
        $result = Auth::attempt($credentials);
        if($result){
            return response()->json([
                "token_type" => "Bearer",
                "token" => $request->user()->createToken("LaravelApi")->plainTextToken,
                "message" => "Success"
            ],200);
        }else{
            return response()->json([
                "message" => "Invalid credentials",
            ]);
        }


    }
    public function signup(Request $request){
        $request->validate([
            "email" => "required|email|unique:users",
            "name" => "required",
            "password" => "required"
        ]);

        $user = User::create([
            "email" => $request->email,
            "name" => $request->name,
            "password" => Hash::make($request->password)
        ]);
        return response()->json([
            "message" => "User registered successfully"
        ]);
    }
    
}
