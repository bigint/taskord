<?php

namespace App\Http\Livewire\Home;

use App\Models\Question;
use Livewire\Component;

class RecentQuestions extends Component
{
    public $readyToLoad = false;

    public function loadRecentQuestions()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        $recent_questions = Question::cacheFor(60 * 60)
            ->select('id', 'title', 'body', 'patronOnly', 'created_at', 'user_id')
            ->orderBy('created_at', 'DESC')
            ->take(5)
            ->get();

        return view('livewire.home.recent-questions', [
            'recent_questions' => $this->readyToLoad ? $recent_questions : [],
        ]);
    }
}
