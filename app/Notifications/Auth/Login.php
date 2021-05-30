<?php

namespace App\Notifications\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Login extends Notification implements ShouldQueue
{
    use Queueable;

    protected $ip;

    public function __construct($ip)
    {
        $this->ip = $ip;
    }

    public function via()
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        if (! $notifiable->spammy) {
            return (new MailMessage())
                ->subject('Account security notice - Successful login')
                ->greeting('Hello @'.$notifiable->username.' 👋')
                ->line('There was a successful login to **'.$notifiable->username.'** from **'.$this->ip.'**. If this was not you please contact us immediately.')
                ->line('Thank you for using Taskord!');
        }

        return null;
    }
}
