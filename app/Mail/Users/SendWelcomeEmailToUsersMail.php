<?php

namespace App\Mail\Users;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendWelcomeEmailToUsersMail extends Mailable
{
    use Queueable, SerializesModels;

    private $notifiable;

    /**
     * Create a new message instance.
     */
    public function __construct($notifiable)
    {
        //
        $this->notifiable = $notifiable;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('support@codency.com.sa', 'Codency'),
            subject: 'Welcome to Condency',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email_templates.auth.welcome',
            with: [
                'username' => $this->notifiable->name,
                'emailTemplateTitle' => 'Welcome to Codency'
            ]
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
