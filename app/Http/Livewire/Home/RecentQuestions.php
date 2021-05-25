<?php

namespace App\Http\Livewire\Home;

use App\Models\Question;
use Livewire\Component;

class RecentQuestions extends Component
{
    public $ready_to_load = false;

    public function loadRecentQuestions()
    {
        $this->ready_to_load = true;
    }

    public function getRecentQuestions()
    {
        return Question::select('id', 'title', 'body', 'patron_only', 'created_at', 'user_id')
            ->orderBy('created_at', 'DESC')
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.home.recent-questions', [
            'recent_questions' => $this->ready_to_load ? $this->getRecentQuestions() : [],
        ]);
    }
}
