<?php

namespace App\Http\Livewire\Home;

use App\Models\Question;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class RecentQuestions extends Component
{
    public $readyToLoad = false;

    public function loadRecentQuestions()
    {
        $this->readyToLoad = true;
    }

    public function getRecentQuestions()
    {
        return Question::select('id', 'slug', 'title', 'body', 'patron_only', 'created_at', 'user_id')
            ->with(['user', 'answers.user'])
            ->withCount('answers')
            ->orderBy('created_at', 'DESC')
            ->take(5)
            ->get();
    }

    public function render(): View
    {
        return view('livewire.home.recent-questions', [
            'recent_questions' => $this->readyToLoad ? $this->getRecentQuestions() : [],
        ]);
    }
}
