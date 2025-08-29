<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpCodeMail;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\OtpService;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:30', 'unique:users,phone'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => $data['password'],
            'is_admin' => false,
        ]);
    }

    // Only registration uses OTP - do not auto login
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        $svc = app(OtpService::class);
        $code = $svc->generate();
        $svc->set($user, $code);

        Mail::to($user->email)->send(new OtpCodeMail(
            $code,
            config('otp.ttl_minutes', 10)
        ));

        // keep context for OTP page
        $request->session()->put('otp_user_id', $user->id);

        return redirect()->route('register.otp.form')
            ->with('status', 'We emailed you a verification code.');
    }
}
