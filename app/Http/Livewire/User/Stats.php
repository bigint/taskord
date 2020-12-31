<?php

namespace App\Http\Livewire\User;

use Livewire\Component;

class Stats extends Component
{
    public $readyToLoad = false;

    public function loadStats()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        return view('livewire.user.stats');
    }
}
