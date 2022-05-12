<?php

namespace App\Modules\Authentication\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * @group Authentication
 *
 * API endpoints for managing authentication
 */
class AuthController extends Controller
{
    /**
     * Log in the user.
     *
     * @bodyParam   user_mail   string  required    The email of the  user. Example: testuser@example.com
     * @bodyParam   password    string  required    The password of the  user.  Example: secret
     *
     * @response {
     *    "user": {
     *       "mail": "testuser@example.com",
     *        "name": "Test User",
     *        "number": "0000000000"
     *    },
     *    "token": "eyJ0eXa..."
     * }
     * 
     * @response 401 {
     *     "message": "The provided credentials do not match our records",
     * }
    */  
    public function login(Request $request)
    {
        $this->validate($request, [
            'user_mail' => ['required','email'],
            'password' => ['required']
        ]);

        $user = User::query()->where('user_mail',$request->user_mail)->first();

        if(!$user || !Hash::check($request->password,$user->password)) return response(['message' => 'The provided credentials do not match our records'],401);

        $token = $user->createToken('user_token')->plainTextToken;

        return response(['user' => new UserResource($user),'token' => $token],201);
    }

    /** 
     * Log Out The User
     * 
     * @authenticated
     * 
     * @response {
     *    "message" : "Successfully Logged Out"  
     * }
     * 
     * @response 401
     * {
     *   "message": "Unauthenticated."
     * }
    */

    public function logout(Request $request) {
        Auth::user()->tokens->each(function($token,$key) {
            $token->delete();
        });
        return response(['message' => 'Successfully Logged Out'],200);
    }

}
