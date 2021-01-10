<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VersionReleased extends Notification implements ShouldQueue
{
    use Queueable;

    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Taskord '.$this->message['tagName'].' has been released!')
                    ->greeting('Hello @'.$notifiable->username.' 👋')
                    ->line('New version of Taskord has been released 🎉')
                    ->line('**Checkout the Changelog [here](https://gitlab.com/taskord/taskord/-/releases/'.$this->message['tagName'].')**')
                    ->line('Thank you for using Taskord!');
    }

    public function toArray($notifiable)
    {
        return [
            'tagName' => $this->message['tagName'],
            'description' => $this->message['description'],
            'user_id' => $notifiable->id,
        ];
    }
}
