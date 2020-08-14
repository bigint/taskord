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

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($task)
    {
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
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

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('Hello @'.$notifiable->username.',')
                    ->line('@'.$this->task->user->username.' mentioned your in the Task.')
                    ->action('Go to Task', url('/task/'.$this->task->id))
                    ->line('Thank you for using our Taskord!');
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
