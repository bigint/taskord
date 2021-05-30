<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramLogger extends Notification
{
    use Queueable;

    protected $ip;
    protected $userAgent;
    protected $type;
    protected $user;
    protected $message;

    public function __construct($ip, $userAgent, $type, $user, $message)
    {
        $this->ip = $ip;
        $this->userAgent = $userAgent;
        $this->type = $type;
        $this->user = $user;
        $this->message = $message;
    }

    public function via()
    {
        return [TelegramChannel::class];
    }

    public function toArray()
    {
        return TelegramMessage::create()
            ->to('-1001407763297')
            ->content("Hello there!\nYour invoice has been *PAID*");
    }
}
