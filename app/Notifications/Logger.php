<?php

namespace App\Notifications;

use Awssat\Notifications\Messages\DiscordMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

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
