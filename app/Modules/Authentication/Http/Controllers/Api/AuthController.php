<?php

namespace App\Modules\Authentication\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
   
    public function login(Request $request)
    {
        $this->validate($request, [
            'user_mail' => ['required','email'],
            'password' => ['required']
        ]);

        $user = User::query()->where('user_mail',$request->user_mail)->first();

        if(!$user || !Hash::check($request->password,$user->password)) return response(['message' => 'The provided credentials do not match our records'],401);

        $token = $user->createToken('user_token')->plainTextToken;

        return response(['user' => $user,'token' => $token],201);
    }

    public function logout(Request $request) {
        Auth::user()->tokens->each(function($token,$key) {
            $token->delete();
        });
        return response()->json('Successfully logged out');
    }

}
