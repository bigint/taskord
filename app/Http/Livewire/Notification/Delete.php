<?php

namespace App\Http\Livewire\Notification;

use Auth;
use Livewire\Component;

class Delete extends Component
{
    public function deleteAll()
    {
        Auth::user()->notifications()->delete();
        $this->emit('deleteAll');
    }

    public function render()
    {
        return view('livewire.notification.delete');
    }
}
