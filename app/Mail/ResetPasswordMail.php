<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $kode; // Kode OTP yang akan dikirim ke email pengguna

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($kode)
    {
        $this->kode = $kode; // Menyimpan kode OTP
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Kode Verifikasi Lupa Password') // Subjek email
                    ->view('emails.reset_password') // Menentukan view email yang akan digunakan
                    ->with(['kode' => $this->kode]); // Mengirimkan kode ke view
    }
}

