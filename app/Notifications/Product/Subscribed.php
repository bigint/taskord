<?php

namespace App\Notifications\Product;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Subscribed extends Notification implements ShouldQueue
{
    use Queueable;

    protected $product;
    protected $userId;

    public function __construct($product, $userId)
    {
        $this->product = $product;
        $this->userId = $userId;
    }

    public function via($notifiable)
    {
        $pref = [];

        if ($notifiable->notifications_email) {
            array_push($pref, 'mail');
        }

        if ($notifiable->notifications_web) {
            array_push($pref, 'database');
        }

        return $pref;
    }

    public function toMail($notifiable)
    {
        $user = User::find($this->userId);

        if (! $user->spammy) {
            return (new MailMessage())
                ->subject('@'.$user->username.' subscribed to "'.$this->product->name.'"')
                ->greeting('Hello @'.$notifiable->username.' 👋')
                ->line('🎉 @'.$user->username.' subscribed to your product "'.$this->product->name.'"')
                ->action('Go to user profile @'.$user->username, url('/@'.$user->username))
                ->line('Thank you for using Taskord!');
        }

        return null;
    }

    public function toDatabase()
    {
        return [
            'product_id' => $this->product->id,
            'user_id' => $this->userId,
        ];
    }
}
