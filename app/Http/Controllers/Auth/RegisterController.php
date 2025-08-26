<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use RegistersUsers;

    // After register+auto-login, go through the same role router
    protected function registered(Request $request, $user)
    {
        return redirect()->route('postlogin.redirect');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required','string','max:255'],
            'email' => ['required','string','email','max:255','unique:users'],
            'password' => ['required','string','min:8','confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            // optional: default new users as non-admin
            'is_admin' => false,
        ]);
    }

    public function __construct()
    {
        $this->middleware('guest');
    }
}
