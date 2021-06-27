<?php

namespace App\Notifications\Answer\Reply;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReplyLiked extends Notification implements ShouldQueue
{
    use Queueable;

    protected $reply;
    protected $userId;

    public function __construct($reply, $userId)
    {
        $this->reply = $reply;
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
                ->subject('@'.$user->username.' liked your reply')
                ->greeting('Hello @'.$notifiable->username.' 👋')
                ->line('👏 Your reply was liked by @'.$user->username)
                ->line($this->reply->reply)
                ->line('Thank you for using Taskord!');
        }

        return null;
    }

    public function toDatabase()
    {
        return [
            'reply_id' => $this->reply->id,
            'user_id' => $this->userId,
        ];
    }
}
