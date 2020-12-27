<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContributorEnabled extends Notification implements ShouldQueue
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
                    ->subject('You are now a contributor to Taskord 🎉')
                    ->greeting('Hello @'.$notifiable->username.' 👋')
                    ->line('You\'ve been marked as a contributor by one of the staff members 🎉')
                    ->line('You can now see the contributor badge in your profile.')
                    ->line('Thank you for using and helping Taskord!');
    }
}
