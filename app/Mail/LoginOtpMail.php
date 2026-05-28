<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LoginOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $code;
    public string $area;

    public function __construct(string $code, string $area)
    {
        $this->code = $code;
        $this->area = $area;
    }

    public function build(): self
    {
        return $this->subject(__('Your login OTP code'))
            ->markdown('emails.login-otp')
            ->with([
                'code' => $this->code,
                'area' => ucfirst($this->area),
            ]);
    }
}
