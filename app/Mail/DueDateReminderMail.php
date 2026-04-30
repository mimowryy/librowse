<?php
namespace App\Mail;

use App\Models\Borrow;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DueDateReminderMail extends Mailable {
    use Queueable, SerializesModels;

    public function __construct(public Borrow $borrow) {}

    public function envelope(): Envelope {
        return new Envelope(
            subject: 'Reminder: Book Due Tomorrow — '.$this->borrow->book->title,
        );
    }

    public function content(): Content {
        return new Content(
            view: 'emails.due-reminder',
        );
    }
}