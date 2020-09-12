<?php

namespace App\Notifications\Product;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class MemberLeft extends Notification implements ShouldQueue
{
    use Queueable;

    protected $product;
    protected $user_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($product, $user_id)
    {
        $this->product = $product;
        $this->user_id = $user_id;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'product_id' => $this->product->id,
            'user_id' => $this->user_id,
        ];
    }
}
