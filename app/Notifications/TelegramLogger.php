<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramLogger extends Notification implements ShouldQueue
{
    use Queueable;

    protected $ip;
    protected $userAgent;
    protected $type;
    protected $user;
    protected $message;
    protected $geoDetails;

    public function __construct($ip, $userAgent, $type, $user, $message, $geoDetails)
    {
        $this->ip = $ip;
        $this->userAgent = $userAgent;
        $this->type = $type;
        $this->user = $user;
        $this->message = $message;
        $this->geoDetails = $geoDetails;
    }

    public function via()
    {
        return [TelegramChannel::class];
    }

    public function toTelegram()
    {
        return TelegramMessage::create()
            ->to('-1001407763297')
            ->content("👤 Caused by: *@".$this->user->username."*\n\n*$this->type • $this->message*");
    }
}
