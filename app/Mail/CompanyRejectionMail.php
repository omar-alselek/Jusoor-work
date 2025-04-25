<?php

namespace App\Mail;

use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CompanyRejectionMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Company $company,
        public string $rejectionReason
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Company Account Application Has Been Rejected',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.company.rejection',
            with: [
                'company' => $this->company,
                'rejectionReason' => $this->rejectionReason,
            ],
        );
    }
} 