<?php

declare(strict_types=1);

namespace App;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class FetchErrorMail extends Mailable
{
    public function __construct(protected string $message)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Fetch Prayer Time Error',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'fetch-error-mail',
            with: [
                'message' => $this->message,
            ],
        );
    }
}
