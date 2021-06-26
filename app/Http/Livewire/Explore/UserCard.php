<?php

namespace App\Http\Livewire\Explore;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class UserCard extends Component
{
    public $readyToLoad = false;

    public function loadUser()
    {
        $this->readyToLoad = true;
    }

    public function render(): View
    {
        return view('livewire.explore.user-card', [
            'user' => $this->readyToLoad ? auth()->user() : [],
        ]);
    }
}
