<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProfileUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $student;

    public function __construct(User $student)
    {
        $this->student = $student;
    }

    public function build()
    {
        return $this->markdown('mail.student.profile-updated')
            ->subject('Your Profile Has Been Updated');
    }
}
