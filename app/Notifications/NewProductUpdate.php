<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewProductUpdate extends Notification implements ShouldQueue
{
    use Queueable;
    
    protected $update;

    public function __construct($update)
    {
        $this->update = $update;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('New product update from "'.$this->update->product->name.'"')
                    ->greeting('Hello @'.$notifiable->username.' 👋')
                    ->line('New product update from "'.$this->update->product->name.'"')
                    ->line($this->update->title)
                    ->line($this->update->body)
                    ->action('Go to '.$this->update->product->name, url('/product/'.$this->update->product->slug))
                    ->line('Thank you for using Taskord!');
    }
}
