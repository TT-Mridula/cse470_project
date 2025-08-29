<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $code;
    public int $minutes;

    public function __construct(string $code, int $minutes)
    {
        $this->code = $code;
        $this->minutes = $minutes;
    }

    public function build()
    {
        $app = config('app.name', 'SkillStacker');

        return $this->subject("Your $app registration code")
            ->view('emails.otp_code')
            ->with([
                'code' => $this->code,
                'minutes' => $this->minutes,
                'appName' => $app,
            ]);
    }
}
