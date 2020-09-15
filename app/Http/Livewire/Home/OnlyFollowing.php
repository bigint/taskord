<?php

namespace App\Http\Livewire\Home;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class OnlyFollowing extends Component
{
    public function onlyFollowingsTasks()
    {
        if (Auth::check()) {
            Auth::user()->onlyFollowingsTasks = ! Auth::user()->onlyFollowingsTasks;
            Auth::user()->save();
            $this->emit('onlyFollowings');
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }
    
    public function render()
    {
        return view('livewire.home.only-following');
    }
}
