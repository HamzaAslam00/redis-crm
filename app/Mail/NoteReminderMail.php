<?php

namespace App\Mail;

use App\Models\NoteReminder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NoteReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public NoteReminder $reminder) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🔔 Note Reminder: '.($this->reminder->note?->title ?: 'Personal Note'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.note-reminder',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
