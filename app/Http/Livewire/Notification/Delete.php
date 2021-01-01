<?php

namespace App\Http\Livewire\Notification;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Delete extends Component
{
    public function deleteAll()
    {
        if (Auth::check()) {
            user()->notifications()->delete();
            $this->emit('deleteAll');
            user()->touch();
            activity()
                ->withProperties(['type' => 'Notification'])
                ->log('Deleted all notifications');

            return $this->alert('success', 'All notifications has been deleted!');
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }
}
