<?php

namespace App\Notifications\Milestone;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MilestonePraised extends Notification implements ShouldQueue
{
    use Queueable;

    protected $milestone;
    protected $userId;

    public function __construct($milestone, $userId)
    {
        $this->milestone = $milestone;
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
                ->subject('@'.$user->username.' praised your milestone')
                ->greeting('Hello @'.$notifiable->username.' 👋')
                ->line('👏 Your milestone was praised by @'.$user->username)
                ->line($this->milestone->title)
                ->line('Thank you for using Taskord!');
        }

        return null;
    }

    public function toDatabase()
    {
        return [
            'milestone_id' => $this->milestone->id,
            'user_id' => $this->userId,
        ];
    }
}
