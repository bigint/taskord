<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskPraised extends Notification implements ShouldQueue
{
    use Queueable;

    protected $task;
    protected $user_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($task, $user_id)
    {
        $this->task = $task;
        $this->user_id = $user_id;
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

        if ($notifiable->taskPraisedEmail) {
            array_push($pref, 'mail');
        }

        if ($notifiable->taskPraisedWeb) {
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
