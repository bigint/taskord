<?php

namespace App\Http\Livewire\Question;

use App\Models\Question;
use Livewire\Component;

class Trending extends Component
{
    public $readyToLoad = false;

    public function loadTrending()
    {
        $this->readyToLoad = true;
    }

    public function getTrending()
    {
        return [];
    }

    public function render()
    {
        return view('livewire.question.trending', [
            'trending' => $this->readyToLoad ? $this->getTrending() : [],
        ]);
    }
}
