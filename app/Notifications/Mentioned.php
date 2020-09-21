<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Mentioned extends Notification implements ShouldQueue
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
        if ($this->type === 'task') {
            return (new MailMessage)
                    ->subject('@'.$this->body->user->username.' mentioned your in a task')
                    ->greeting('Hello @'.$notifiable->username.' 👋')
                    ->line('@'.$this->body->user->username.' mentioned your in a task.')
                    ->line($this->body->task)
                    ->action('Go to Task', url('/task/'.$this->body->id))
                    ->line('Thank you for using Taskord!');
        } elseif ($this->type === 'comment') {
            return (new MailMessage)
                    ->subject('@'.$this->body->user->username.' mentioned your in a comment')
                    ->greeting('Hello @'.$notifiable->username.' 👋')
                    ->line('@'.$this->body->user->username.' mentioned your in a comment.')
                    ->line($this->body->comment)
                    ->action('Go to Task', url('/task/'.$this->body->task->id))
                    ->line('Thank you for using Taskord!');
        } elseif ($this->type === 'answer') {
            return (new MailMessage)
                    ->subject('@'.$this->body->user->username.' mentioned your in an answer')
                    ->greeting('Hello @'.$notifiable->username.' 👋')
                    ->line('@'.$this->body->user->username.' mentioned your in an answer.')
                    ->line($this->body->answer)
                    ->action('Go to Question', url('/question/'.$this->body->question->id))
                    ->line('Thank you for using Taskord!');
        }
    }

    public function toDatabase($notifiable)
    {
        if ($this->type === 'task') {
            $body = $this->body->task;
        } elseif ($this->type === 'comment') {
            $body = $this->body->comment;
        } elseif ($this->type === 'answer') {
            $body = $this->body->answer;
        }

        return [
            'body' => $body,
            'body_id' => $this->body->id,
            'body_type' => $this->type,
            'user_id' => $this->body->user->id,
        ];
    }
}
