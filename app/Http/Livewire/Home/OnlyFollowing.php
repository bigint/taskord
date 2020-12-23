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

            if (Auth::user()->onlyFollowingsTasks) {
                return $this->alert('success', 'Only following users tasks will be vissible!');
            } else {
                return $this->alert('success', 'All users tasks will be vissible!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }
}
