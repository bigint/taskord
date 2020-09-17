<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Subscribed extends Notification implements ShouldQueue
{
    use Queueable;

    protected $product;
    protected $user_id;

    public function __construct($product, $user_id)
    {
        $this->product = $product;
        $this->user_id = $user_id;
    }

    public function via($notifiable)
    {
        $pref = [];

        if ($notifiable->productSubscribedEmail) {
            array_push($pref, 'mail');
        }

        if ($notifiable->productSubscribedWeb) {
            array_push($pref, 'database');
        }

        return $pref;
    }

    public function toMail($notifiable)
    {
        $user = User::find($this->user_id);

        return (new MailMessage)
                    ->subject('@'.$user->username.' subscribed to "'.$this->product->name.'"')
                    ->greeting('Hello @'.$notifiable->username.' 👋')
                    ->line('🎉 @'.$user->username.' subscribed to your product "'.$this->product->name.'"')
                    ->action('Go to user profile @'.$user->username, url('/@'.$user->username))
                    ->line('Thank you for using Taskord!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'product_id' => $this->product->id,
            'user_id' => $this->user_id,
        ];
    }
}
