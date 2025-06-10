<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $verificationUrl;

    public function __construct($user, $verificationUrl)
    {
        $this->user = $user;
        $this->verificationUrl = $verificationUrl;
    }

    public function envelope(): \Illuminate\Mail\Mailables\Envelope
    {
        return new \Illuminate\Mail\Mailables\Envelope(
            subject: 'Verify Your Email Address',
        );
    }

    public function content(): \Illuminate\Mail\Mailables\Content
    {
        return new \Illuminate\Mail\Mailables\Content(
            view: 'emails.verifyEmail', // Blade وليس Markdown
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
