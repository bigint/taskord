<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskMentioned extends Notification implements ShouldQueue
{
    use Queueable;

    protected $body;
    protected $type;

    public function __construct($body, $type)
    {
        $this->body = $body;
        $this->type = $type;
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
                    ->subject('@'.$this->body->user->username.' mentioned your in the Task')
                    ->greeting('Hello @'.$notifiable->username.' 👋')
                    ->line('@'.$this->body->user->username.' mentioned your in the Task.')
                    ->line($this->body->task)
                    ->action('Go to Task', url('/task/'.$this->body->id))
                    ->line('Thank you for using Taskord!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'body' => $this->body->task,
            'body_id' => $this->body->id,
            'body_type' => $this->type,
            'user_id' => $this->body->user->id,
        ];
    }
}
