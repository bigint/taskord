<?php

namespace App\Http\Livewire\Explore;

use Livewire\Component;

class PopularTasks extends Component
{
    public $readyToLoad = false;

    public function loadPopularTasks()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        return view('livewire.explore.popular-tasks');
    }
}
