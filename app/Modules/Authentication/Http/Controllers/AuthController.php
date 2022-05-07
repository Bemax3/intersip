<?php

namespace App\Modules\Authentication\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function index() {
        return Inertia::render('Login');
    }

    public function signin(Request $req) {
        auth()->logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();
        $this->validate($req, [
            'user_mail' => ['required','email'],
            'password' => ['required']
        ]);
        if(!auth()->attempt($req->only('user_mail','password'))) {
            return back()->withErrors([
                'signinError' => 'The provided credentials do not match our records',
            ]);
        }

        $req->session()->regenerate();
        return redirect()->route('contacts.list.contacts');
    }

    public function signout(Request $req) {
        auth()->logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();
        return redirect()->route('authentication.signin');
    }
}
