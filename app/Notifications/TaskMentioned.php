<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskMentioned extends Notification implements ShouldQueue
{
    use Queueable;

    protected $task;

    public function __construct($task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        $pref = [];

        if ($notifiable->taskMentionedEmail) {
            array_push($pref, 'mail');
        }

        if ($notifiable->taskMentionedWeb) {
            array_push($pref, 'database');
        }

        return $pref;
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('@'.$this->task->user->username.' mentioned your in the Task')
                    ->greeting('Hello @'.$notifiable->username.' 👋')
                    ->line('@'.$this->task->user->username.' mentioned your in the Task.')
                    ->line($this->task->task)
                    ->action('Go to Task', url('/task/'.$this->task->id))
                    ->line('Thank you for using Taskord!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'task' => $this->task->task,
            'task_id' => $this->task->id,
            'user_id' => $this->task->user->id,
        ];
    }
}
