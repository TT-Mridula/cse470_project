<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpCodeMail;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class OtpUiController extends Controller
{
    public function show(Request $request)
    {
        if (! $request->session()->has('otp_user_id')) {
            return redirect()->route('login');
        }
        return view('auth.otp');
    }

    public function verify(Request $request, OtpService $svc)
    {
        $request->validate([
            'code' => ['required', 'digits:'.config('otp.length', 6)],
        ]);

        $userId = $request->session()->get('otp_user_id');
        if (! $userId) {
            return redirect()->route('login');
        }

        /** @var \App\Models\User|null $user */
        $user = User::find($userId);
        if (! $user) {
            return redirect()->route('login');
        }

        $key = 'otp:reg:'.$user->id;
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $sec = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'code' => "Too many attempts. Try again in {$sec} seconds.",
            ]);
        }

        if ($svc->expired($user)) {
            throw ValidationException::withMessages(['code' => 'Code expired. Request a new one.']);
        }

        if ($user->otp_code !== $request->input('code')) {
            $user->increment('otp_attempts');
            RateLimiter::hit($key, 60);
            throw ValidationException::withMessages(['code' => 'Invalid code.']);
        }

        if (is_null($user->email_verified_at)) {
            $user->forceFill(['email_verified_at' => now()])->save();
        }
        $svc->clear($user);

        Auth::login($user, false);
        $request->session()->forget('otp_user_id');

        return redirect()->intended(route('home'));
    }

    public function resend(Request $request, OtpService $svc)
    {
        $userId = $request->session()->get('otp_user_id');
        if (! $userId) {
            return redirect()->route('login');
        }

        $user = User::findOrFail($userId);

        $code = $svc->generate();
        $svc->set($user, $code);

        Mail::to($user->email)->send(new OtpCodeMail(
            $code,
            config('otp.ttl_minutes', 10)
        ));

        return back()->with('status', 'A new code has been sent.');
            
    }
}

