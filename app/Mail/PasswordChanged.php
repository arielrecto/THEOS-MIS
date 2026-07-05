<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $student;

    public function __construct(User $student)
    {
        $this->student = $student;
    }

    public function build()
    {
        return $this->markdown('mail.student.password-changed')
            ->subject('Your Password Has Been Changed');
    }
}
