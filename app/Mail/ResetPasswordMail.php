<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;


class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Token reset password
     */
    protected $token;

    /**
     * Buat instance pesan baru.
     *
     * @param string $token
     */
    public function __construct($token)
{
    Log::info('Token received in Mailable: ' . $token);
    $this->token = $token;
}

    /**
     * Mendapatkan envelope pesan.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset Password E-Mail',
        );
    }

    /**
     * Mendapatkan konten pesan.
     */
    public function content(): Content
    {
        return new Content(
            view: 'auth.mail.reset-password',
            with: [
                'token' => $this->token,  // Token diteruskan ke view
            ]
        );
    }

    /**
     * Mendapatkan lampiran untuk pesan.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
