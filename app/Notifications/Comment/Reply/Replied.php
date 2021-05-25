<?php

namespace App\Notifications\Comment\Reply;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Replied extends Notification implements ShouldQueue
{
    use Queueable;

    protected $reply;
    protected $user_id;

    public function __construct($reply)
    {
        $this->reply = $reply;
        $this->user_id = $reply->user->id;
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
        $user = User::find($this->user_id);

        if (! $user->spammy) {
            return (new MailMessage)
                        ->subject('@'.$user->username.' replied to your comment')
                        ->greeting('Hello @'.$notifiable->username.' 👋')
                        ->line('💬 Your comment has new reply by @'.$user->username)
                        ->line('Comment: '.$this->reply->comment->comment)
                        ->line('Reply: '.$this->reply->reply)
                        ->action('Go to Comment', url('/task/'.$this->reply->comment->task->id.'/'.$this->reply->comment->id))
                        ->line('Thank you for using Taskord!');
        } else {
            return null;
        }
    }

    public function toDatabase($notifiable)
    {
        return [
            'reply_id' => $this->reply->id,
            'user_id' => $this->user_id,
        ];
    }
}
