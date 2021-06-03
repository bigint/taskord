<?php

namespace App\Notifications\Task;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskLiked extends Notification implements ShouldQueue
{
    use Queueable;

    protected $task;
    protected $userId;

    public function __construct($task, $userId)
    {
        $this->task = $task;
        $this->userId = $userId;
    }

    public function via($notifiable)
    {
        $pref = [];

        if ($notifiable->notifications_email) {
            array_push($pref, 'mail');
        }

        if ($notifiable->notifications_web) {
            array_push($pref, 'database');
        }

        return $pref;
    }

    public function toMail($notifiable)
    {
        $user = User::find($this->userId);

        if (! $user->spammy) {
            return (new MailMessage())
                ->subject('@'.$user->username.' liked your task')
                ->greeting('Hello @'.$notifiable->username.' 👋')
                ->line('👍 Your task was liked by @'.$user->username)
                ->line($this->task->task)
                ->action('Go to Task', url('/task/'.$this->task->id))
                ->line('Thank you for using Taskord!');
        }

        return null;
    }

    public function toDatabase()
    {
        return [
            'task_id' => $this->task->id,
            'user_id' => $this->userId,
        ];
    }
}
