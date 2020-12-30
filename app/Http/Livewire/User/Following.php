<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;

class Following extends Component
{
    public User $user;
    public $readyToLoad = false;

    public function loadFollowing()
    {
        $this->readyToLoad = true;
    }

    public function mount($user)
    {
        $this->user = $user;
    }

    public function render()
    {
        $followings = $this->user->followings;

        return view('livewire.user.following', [
            'followings' => $this->readyToLoad ? $followings : [],
        ]);
    }
}
