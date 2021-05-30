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
    protected $userId;

    public function __construct($comment)
    {
        $this->comment = $comment;
        $this->userId = $comment->user->id;
    }

    public function via()
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $user = User::find($this->userId);

        if (! $user->spammy) {
            return (new MailMessage())
                ->subject('@'.$user->username.' commented on a subscribed task')
                ->greeting('Hello @'.$notifiable->username.' 👋')
                ->line('💬 The task you subscribe to has a new comment by @'.$user->username)
                ->line('Task: '.$this->comment->task->task)
                ->line('Comment: '.$this->comment->comment)
                ->action('Go to Task', url('/task/'.$this->comment->task->id))
                ->line('Thank you for using Taskord!');
        }

        return null;
    }

    public function toArray()
    {
        return [
            'comment_id' => $this->comment->id,
            'user_id' => $this->userId,
        ];
    }
}
