<?php
namespace App\Mail;

use App\Models\Borrow;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OverdueReminderMail extends Mailable {
    use Queueable, SerializesModels;

    public function __construct(public Borrow $borrow) {}

    public function envelope(): Envelope {
        return new Envelope(
            subject: 'Overdue Book — '.$this->borrow->book->title,
        );
    }

    public function content(): Content {
        return new Content(
            view: 'emails.overdue-reminder',
        );
    }
}