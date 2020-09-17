<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MagicLink extends Notification implements ShouldQueue
{
    use Queueable;

    protected $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Magic link to login into Taskord')
                    ->greeting('Hello @'.$notifiable->username.' 👋')
                    ->line('Here is your magic link to login into Taskord!.')
                    ->action('Login now', url($this->url))
                    ->line('Thank you for using Taskord!');
    }
}
