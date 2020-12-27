<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserVerified extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Your account has been verified ✅')
                    ->greeting('Hello @'.$notifiable->username.' 👋')
                    ->line('Your account has been verified by one of the staff members 🎉')
                    ->line('You can see the verified badge everywhere next to your name.')
                    ->line('Thank you for using Taskord!');
    }
}
