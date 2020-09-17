<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskPraised extends Notification implements ShouldQueue
{
    use Queueable;

    protected $task;
    protected $user_id;

    public function __construct($task, $user_id)
    {
        $this->task = $task;
        $this->user_id = $user_id;
    }

    public function via($notifiable)
    {
        $pref = [];

        if ($notifiable->taskPraisedEmail) {
            array_push($pref, 'mail');
        }

        if ($notifiable->taskPraisedWeb) {
            array_push($pref, 'database');
        }

        return $pref;
    }

    public function toMail($notifiable)
    {
        $user = User::find($this->user_id);

        return (new MailMessage)
                    ->subject('@'.$user->username.' praised your task')
                    ->greeting('Hello @'.$notifiable->username.' 👋')
                    ->line('👏 Your task was praised by @'.$user->username)
                    ->line($this->task->task)
                    ->action('Go to Task', url('/task/'.$this->task->id))
                    ->line('Thank you for using Taskord!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'task' => $this->task->task,
            'task_id' => $this->task->id,
            'user_id' => $this->user_id,
        ];
    }
}
