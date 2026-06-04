<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $userName) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'We received your message!');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.user-confirmation');
    }
}