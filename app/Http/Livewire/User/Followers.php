<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;

class Followers extends Component
{
    public User $user;
    public $readyToLoad = false;

    public function loadFollowers()
    {
        $this->readyToLoad = true;
    }

    public function mount($user)
    {
        $this->user = $user;
    }

    public function render()
    {
        $followers = $this->user->followers;

        return view('livewire.user.followers', [
            'followers' => $this->readyToLoad ? $followers : [],
        ]);
    }
}
