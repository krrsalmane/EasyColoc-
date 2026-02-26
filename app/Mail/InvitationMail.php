<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Invitation;

class InvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        // public readonly Invitation $invitation,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "You're invited to join ",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.test',
            with: [
                'invitation' => 'test'
            ],
        );
    }

}