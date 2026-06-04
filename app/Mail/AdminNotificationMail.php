<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $userName,
        public string $userEmail,
        public string $userMessage
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'New Contact Form Submission');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.admin-notification');
    }
}