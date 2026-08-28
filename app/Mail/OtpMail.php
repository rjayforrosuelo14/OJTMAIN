<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $otpCode;

    public function __construct(string $otpCode)
    {
        $this->otpCode = $otpCode;
    }

    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Your OJT Verification Code')
            ->view('emails.otp')
            ->with([
                'otpCode' => $this->otpCode,
            ]);
    }
}














