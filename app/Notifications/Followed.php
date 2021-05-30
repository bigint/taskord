<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Followed extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
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
        $user = User::find($this->user->id);

        if (! $user->spammy) {
            return (new MailMessage())
                ->subject('@'.$user->username.' followed you')
                ->greeting('Hello @'.$notifiable->username.' 👋')
                ->line('@'.$user->username.' followed you on Taskord.')
                ->action('Go to user profile @'.$user->username, url('/@'.$user->username))
                ->line('Thank you for using Taskord!');
        }

        return null;
    }

    public function toDatabase()
    {
        return [
            'user_id' => $this->user->id,
        ];
    }
}
