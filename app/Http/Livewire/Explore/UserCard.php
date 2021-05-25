<?php

namespace App\Http\Livewire\Explore;

use Livewire\Component;

class UserCard extends Component
{
    public $ready_to_load = false;

    public function loadUser()
    {
        $this->ready_to_load = true;
    }

    public function render()
    {
        return view('livewire.explore.user-card', [
            'user' => $this->ready_to_load ? auth()->user() : [],
        ]);
    }
}
