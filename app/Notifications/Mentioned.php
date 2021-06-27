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
        if ($this->type === 'task') {
            return (new MailMessage())
                ->subject('@'.$this->body->user->username.' mentioned you in a task')
                ->greeting('Hello @'.$notifiable->username.' 👋')
                ->line('@'.$this->body->user->username.' mentioned you in a task.')
                ->line($this->body->task)
                ->action('Go to Task', url('/task/'.$this->body->id))
                ->line('Thank you for using Taskord!');
        }

        if ($this->type === 'comment') {
            return (new MailMessage())
                ->subject('@'.$this->body->user->username.' mentioned you in a comment')
                ->greeting('Hello @'.$notifiable->username.' 👋')
                ->line('@'.$this->body->user->username.' mentioned you in a comment.')
                ->line($this->body->comment)
                ->action('Go to Task', url('/task/'.$this->body->task->id))
                ->line('Thank you for using Taskord!');
        }

        if ($this->type === 'comment_reply') {
            return (new MailMessage())
                ->subject('@'.$this->body->user->username.' mentioned you in a comment reply')
                ->greeting('Hello @'.$notifiable->username.' 👋')
                ->line('@'.$this->body->user->username.' mentioned you in a comment reply.')
                ->line($this->body->reply)
                ->action('Go to Comment', url('/task/'.$this->body->comment->task->id.'/'.$this->body->comment->id))
                ->line('Thank you for using Taskord!');
        }

        if ($this->type === 'answer_reply') {
            return (new MailMessage())
                ->subject('@'.$this->body->user->username.' mentioned you in a answer reply')
                ->greeting('Hello @'.$notifiable->username.' 👋')
                ->line('@'.$this->body->user->username.' mentioned you in a answer reply.')
                ->line($this->body->reply)
                ->action('Go to Question', url('/question/'.$this->body->question->slug))
                ->line('Thank you for using Taskord!');
        }

        if ($this->type === 'answer') {
            return (new MailMessage())
                ->subject('@'.$this->body->user->username.' mentioned you in an answer')
                ->greeting('Hello @'.$notifiable->username.' 👋')
                ->line('@'.$this->body->user->username.' mentioned you in an answer.')
                ->line($this->body->answer)
                ->action('Go to Question', url('/question/'.$this->body->question->id))
                ->line('Thank you for using Taskord!');
        }
    }

    public function toDatabase()
    {
        if ($this->type === 'task') {
            $id = $this->body->id;
            $entityId = null;
        } elseif ($this->type === 'comment') {
            $id = $this->body->task->id;
            $entityId = $this->body->id;
        } elseif ($this->type === 'comment_reply') {
            $id = $this->body->comment->id;
            $entityId = $this->body->id;
        } elseif ($this->type === 'answer_reply') {
            $id = $this->body->answer->id;
            $entityId = $this->body->id;
        } elseif ($this->type === 'answer') {
            $id = $this->body->question->id;
            $entityId = $this->body->id;
        }

        return [
            'body_id' => $id,
            'entity_id' => $entityId,
            'body_type' => $this->type,
            'user_id' => $this->body->user->id,
        ];
    }
}
