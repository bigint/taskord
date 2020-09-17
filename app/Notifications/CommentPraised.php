<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentPraised extends Notification implements ShouldQueue
{
    use Queueable;

    protected $comment;
    protected $user_id;

    public function __construct($comment, $user_id)
    {
        $this->comment = $comment;
        $this->user_id = $user_id;
    }

    public function via($notifiable)
    {
        $pref = [];

        if ($notifiable->commentPraisedEmail) {
            array_push($pref, 'mail');
        }

        if ($notifiable->commentPraisedWeb) {
            array_push($pref, 'database');
        }

        return $pref;
    }

    public function toMail($notifiable)
    {
        $user = User::find($this->user_id);

        return (new MailMessage)
                    ->subject('@'.$user->username.' praised your comment')
                    ->greeting('Hello @'.$notifiable->username.' 👋')
                    ->line('👏 Your comment was praised by @'.$user->username)
                    ->line($this->comment->comment)
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
