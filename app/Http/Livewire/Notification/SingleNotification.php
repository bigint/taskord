<?php

namespace App\Http\Livewire\Notification;

use Livewire\Component;

class SingleNotification extends Component
{
    public $notification_id;
    public $type;
    public $data;
    public $created_at;
    public $page_type;

    public function mount($notification_id, $type, $data, $created_at, $page_type)
    {
        $this->notification_id = $notification_id;
        $this->type = $type;
        $this->page_type = $page_type;
        $this->data = $data;
        $this->created_at = strval($created_at);
    }

    public function markSingleNotificationAsRead()
    {
        auth()->user()->unreadNotifications->where('id', $this->notification_id)->markAsRead();
        $this->emit('markAsRead');
        activity()
            ->withProperties(['type' => 'Notification'])
            ->log('Single notification is marked as read');

        return $this->alert('success', 'Notifications is marked as read!');
    }
}
