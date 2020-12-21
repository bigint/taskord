<?php

namespace App\Http\Livewire\Notification;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Delete extends Component
{
    public function deleteAll()
    {
        if (Auth::check()) {
            Auth::user()->notifications()->delete();
            $this->emit('deleteAll');
            Auth::user()->touch();
            activity()
                ->withProperties(['type' => 'Notification'])
                ->log('Deleted all notifications');
        } else {
            return $this->alert('error', 'Forbidden!', [
                'showCancelButton' => true,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.notification.delete');
    }
}
