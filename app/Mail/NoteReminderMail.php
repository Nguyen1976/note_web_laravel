<?php

namespace App\Mail;

use App\Models\Note;
use App\Models\Reminder;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class NoteReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public Collection $notes;
    public Reminder $reminder;



    /**
     * Create a new message instance.
     */
    public function __construct(User $user, Collection $notes, Reminder $reminder)
    {
        $this->user = $user;
        $this->notes = $notes;
        $this->reminder = $reminder;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bạn có các ghi chú cần được nhắc nhở!',

        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.notes.reminder',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
