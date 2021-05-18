<?php

namespace App\Http\Livewire\Home;

use Livewire\Component;

class OnlyFollowing extends Component
{
    public function onlyFollowingsTasks()
    {
        if (auth()->check()) {
            auth()->user()->onlyFollowingsTasks = ! auth()->user()->onlyFollowingsTasks;
            auth()->user()->save();
            $this->emit('onlyFollowings');
            loggy(request(), 'User', auth()->user(), 'Toggled only followings tasks');

            if (auth()->user()->onlyFollowingsTasks) {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'success',
                    'body' => 'Only following users tasks will be visible!',
                ]);
            } else {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'success',
                    'body' => 'All users tasks will be visible!',
                ]);
            }
        } else {
            return $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Forbidden!',
            ]);
        }
    }
}
