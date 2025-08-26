<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    // After a successful login, send everyone to /redirect (your role router)
    protected function authenticated(Request $request, $user)
    {
        return redirect()->route('postlogin.redirect');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}