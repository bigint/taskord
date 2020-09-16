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
        } else {
            return session()->flash('global', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.notification.delete');
    }
}
