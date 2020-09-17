<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Commented extends Notification implements ShouldQueue
{
    use Queueable;

    protected $comment;
    protected $user_id;

    public function __construct($comment)
    {
        $this->comment = $comment;
        $this->user_id = $comment->user->id;
    }

    public function via($notifiable)
    {
        $pref = [];

        if ($notifiable->commentAddedEmail) {
            array_push($pref, 'mail');
        }

        if ($notifiable->commentAddedWeb) {
            array_push($pref, 'database');
        }

        return $pref;
    }

    public function toMail($notifiable)
    {
        $user = User::find($this->user_id);

        return (new MailMessage)
                    ->subject('@'.$user->username.' commented your task')
                    ->greeting('Hello @'.$notifiable->username.' 👋')
                    ->line('👏 Your task has new comment by @'.$user->username)
                    ->line('Task: '.$this->comment->task->task)
                    ->line('Comment: '.$this->comment->comment)
                    ->action('Go to Task', url('/task/'.$this->comment->task->id))
                    ->line('Thank you for using Taskord!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'comment' => $this->comment->comment,
            'comment_id' => $this->comment->id,
            'task_id' => $this->comment->task->id,
            'user_id' => $this->user_id,
        ];
    }
}
