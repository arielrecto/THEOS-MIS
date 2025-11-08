<?php


namespace App\Mail;

use App\Models\EnrollmentForm;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnrollmentStatusUpdate extends Mailable
{
    use Queueable, SerializesModels;

    public $enrollee;
    public $status;
    public $remarks;

    public function __construct(EnrollmentForm $enrollee, string $status, ?string $remarks = null)
    {
        $this->enrollee = $enrollee;
        $this->status = $status;
        $this->remarks = $remarks;
    }

    public function build()
    {
        return $this->markdown('mail.enrollment.status-update')
            ->subject('Enrollment Status Update');
    }
}
