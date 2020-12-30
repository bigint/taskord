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

    public function render()
    {
        $trending = Question::cacheFor(60 * 60)
            ->orderByViews()
            ->has('answer')
            ->take(5)
            ->get()
            ->sortByDesc(function ($question) {
                return $question->answer->count('id');
            });

        return view('livewire.question.trending', [
            'trending' => $this->readyToLoad ? $trending : [],
        ]);
    }
}
