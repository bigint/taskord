<?php

namespace App\Http\Livewire\Question;

use App\Models\Question;
use Livewire\Component;

class Trending extends Component
{
    public $ready_to_load = false;

    public function loadTrending()
    {
        $this->ready_to_load = true;
    }

    public function getTrending()
    {
        return Question::orderByViews()
            ->has('answer')
            ->take(5)
            ->get()
            ->sortByDesc(function ($question) {
                return $question->answer->count('id');
            });
    }

    public function render()
    {
        return view('livewire.question.trending', [
            'trending' => $this->ready_to_load ? $this->getTrending() : [],
        ]);
    }
}
