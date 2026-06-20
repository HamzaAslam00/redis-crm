<?php

namespace App\Mail;

use App\Models\ContactReply;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ContactReply $reply) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->reply->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.contact-reply',
        );
    }
}
