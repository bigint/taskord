<?php

namespace App\Notifications\Comment;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentPraised extends Notification implements ShouldQueue
{
    use Queueable;

    protected $comment;
    protected $userId;

    public function __construct($comment, $userId)
    {
        $this->comment = $comment;
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
                ->subject('@'.$user->username.' praised your comment')
                ->greeting('Hello @'.$notifiable->username.' 👋')
                ->line('👏 Your comment was praised by @'.$user->username)
                ->line($this->comment->comment)
                ->line('Thank you for using Taskord!');
        }

        return null;
    }

    public function toDatabase()
    {
        return [
            'comment_id' => $this->comment->id,
            'task_id' => $this->comment->task->id,
            'user_id' => $this->userId,
        ];
    }
}
