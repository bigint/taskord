<?php

namespace App\Http\Livewire\Notification;

use Livewire\Component;

class SingleNotification extends Component
{
    public $type;
    public $data;
    public $created_at;

    public function mount($type, $data, $created_at)
    {
        $this->type = $type;
        $this->data = $data;
        $this->created_at = strval($created_at);
    }

    public function render()
    {
        return view('livewire.notification.single-notification');
    }
}
