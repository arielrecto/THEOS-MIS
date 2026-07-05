<?php

namespace App\Notifications;

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected Task $task,
        protected User $student,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $subject = $this->task->classroom?->subject?->name ?? 'N/A';
        $deadline = Carbon::parse($this->task->end_date)->format('F d, Y');

        return (new MailMessage)
            ->subject('New Task Assigned: ' . $this->task->name)
            ->greeting('Hello!')
            ->line('Dear ' . $this->student->name . ',')
            ->line('A new activity task has been assigned. Please review the details and complete it within the specified deadline.')
            ->line('**Subject:** ' . $subject)
            ->line('**Task:** ' . $this->task->name)
            ->line('**Deadline:** ' . $deadline)
            ->line('For clarifications, contact your adviser.')
            ->salutation("Regards,\n" . config('app.name') . "\n\n---\n*This is an auto-generated email. Do not reply to this message.*");
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
