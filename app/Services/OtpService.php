<?php

namespace App\Services;

use App\Models\User;

class OtpService
{
    public function generate(?int $length = null): string
    {
        $len = (int) ($length ?? config('otp.length', 6));
        $max = (10 ** $len) - 1;

        return str_pad((string) random_int(0, $max), $len, '0', STR_PAD_LEFT);
    }

    public function set(User $user, string $code, ?int $ttlMinutes = null): void
    {
        $ttl = (int) ($ttlMinutes ?? config('otp.ttl_minutes', 10));

        $user->forceFill([
            'otp_code'       => $code,
            'otp_expires_at' => now()->addMinutes($ttl),
            'otp_attempts'   => 0,
        ])->save();
    }

    public function expired(User $user): bool
    {
        return empty($user->otp_code)
            || empty($user->otp_expires_at)
            || now()->greaterThan($user->otp_expires_at);
    }

    public function clear(User $user): void
    {
        $user->forceFill([
            'otp_code'       => null,
            'otp_expires_at' => null,
            'otp_attempts'   => 0,
        ])->save();
    }
}

