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

            return $this->alert('success', 'All notifications has been deleted!', [
                'showCancelButton' =>  false,
            ]);
        } else {
            return $this->alert('error', 'Forbidden!', [
                'showCancelButton' =>  false,
            ]);
        }
    }
}
