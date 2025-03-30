<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class EmployeeCredentials extends Mailable
{
    use SerializesModels;

    public $user;
    public $password;

    public function __construct(User $user, string $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to ' . config('app.name') . ' - Your Account Credentials',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.employee.credentials',
            with: [
                'user' => $this->user,
                'password' => $this->password,
            ],
        );
    }
}
