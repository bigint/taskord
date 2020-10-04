<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;
use Awssat\Notifications\Messages\DiscordMessage;

class Logger extends Notification implements ShouldQueue
{
    use Queueable;

    protected $type;
    protected $staff;
    protected $user;
    protected $message;

    public function __construct($type, $staff, $user, $message)
    {
        $this->type = $type;
        $this->staff = $staff;
        $this->user = $user;
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['discord'];
    }
    
    public function toDiscord($notifiable)
    {
        return (new DiscordMessage)
            ->embed(function ($embed) {
                $embed->title($this->message)
                    ->description($this->type)
                    ->color(69723)
                    ->field('Staff', '@'.$this->staff->username, true)
                    ->field('User', '@'.$this->user->username, true);
            });
    }
}
