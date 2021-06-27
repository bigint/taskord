<?php

namespace App\Notifications\Answer\Reply;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Replied extends Notification implements ShouldQueue
{
    use Queueable;

    protected $reply;
    protected $userId;

    public function __construct($reply)
    {
        $this->reply = $reply;
        $this->userId = $reply->user->id;
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
                ->subject('@'.$user->username.' replied to your answer')
                ->greeting('Hello @'.$notifiable->username.' 👋')
                ->line('💬 Your answer has new reply by @'.$user->username)
                ->line('Answer: '.$this->reply->answer->answer)
                ->line('Reply: '.$this->reply->reply)
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
