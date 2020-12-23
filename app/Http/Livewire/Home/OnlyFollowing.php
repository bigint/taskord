<?php

namespace App\Http\Livewire\Home;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OnlyFollowing extends Component
{
    public function onlyFollowingsTasks()
    {
        if (Auth::check()) {
            Auth::user()->onlyFollowingsTasks = ! Auth::user()->onlyFollowingsTasks;
            Auth::user()->save();
            $this->emit('onlyFollowings');
            activity()
                    ->withProperties(['type' => 'User'])
                    ->log('Toggled only followings tasks in homepage');
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.home.only-following');
    }
}
