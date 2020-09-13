<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramLogger extends Notification implements ShouldQueue
{
    use Queueable;

    protected $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        if (\App::environment() === 'production') {
            return [TelegramChannel::class];
        }
    }

    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
                    ->to('-1001460907028')
                    ->content($this->message);
    }
}
