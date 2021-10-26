<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;


    // مقداردهی متغیر
    public $otp;




    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */

    // محتوای ایمیل مان را توسط یک بلید ست کردن
    public function build()
    {
        // from('Source Email')
        return $this->from('binmoein8@gmail.com')
            ->view('mail.otp');
    }
}
