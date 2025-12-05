<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewFormSubmission extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $formType,
        public array $data,
        public ?string $replyToEmail = null,
        public ?string $replyToName = null,
    ) {}

    public function envelope(): Envelope
    {
        $subjects = [
            'contact' => 'New Contact Form Submission',
            'quote' => 'New Quote Request',
            'training' => 'New Training Booking Request',
            'equipment' => 'New Equipment Rental Enquiry',
            'lead' => 'New Resource Download Lead',
        ];

        $envelope = new Envelope(
            subject: $subjects[$this->formType] ?? 'New Website Enquiry',
        );

        if ($this->replyToEmail) {
            $envelope->replyTo[] = new Address($this->replyToEmail, $this->replyToName ?? '');
        }

        return $envelope;
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.form-submission',
            with: [
                'formType' => $this->formType,
                'data' => $this->data,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
