<?php

namespace App\Http\Livewire\Explore;

use Livewire\Component;

class User extends Component
{
    public $readyToLoad = false;

    public function loadUser()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        $user = auth()->user();

        return view('livewire.explore.user', [
            'user' => $this->readyToLoad ? $user : [],
        ]);
    }
}
