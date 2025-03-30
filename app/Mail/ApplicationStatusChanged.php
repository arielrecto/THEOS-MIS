<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\JobApplicant;

class ApplicationStatusChanged extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $applicant;
    public $oldStatus;
    public $newStatus;


    public function __construct(JobApplicant $applicant, $oldStatus, $newStatus)
    {
        $this->applicant = $applicant;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    public function envelope(): Envelope
    {
        $subject = match($this->newStatus) {
            'screening' => 'Application Shortlisted - Next Steps',
            'interview' => 'Interview Invitation',
            'hired' => 'Congratulations! Job Offer',
            'rejected' => 'Application Status Update',
            default => 'Application Status Update'
        };

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.recruitment.status-changed',
            with : [
                'applicant' => $this->applicant,
                'newStatus' => $this->newStatus
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
