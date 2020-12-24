<?php

namespace App\Notifications\Task;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifySubscribers extends Notification implements ShouldQueue
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
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $user = User::find($this->user_id);

        return (new MailMessage)
                    ->subject('@'.$user->username.' commented on the task')
                    ->greeting('Hello @'.$notifiable->username.' 👋')
                    ->line('💬 The task you subscribed has new comment by @'.$user->username)
                    ->line('Task: '.$this->comment->task->task)
                    ->line('Comment: '.$this->comment->comment)
                    ->action('Go to Task', url('/task/'.$this->comment->task->id))
                    ->line('Thank you for using Taskord!');
    }

    public function toArray($notifiable)
    {
        return [
            'comment' => $this->comment->comment,
            'comment_id' => $this->comment->id,
            'task_id' => $this->comment->task->id,
            'user_id' => $this->user_id,
        ];
    }
}
