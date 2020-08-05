<?php

namespace App\Http\Livewire\User;

use App\Question;
use Livewire\Component;

class Questions extends Component
{
    public $user_id;

    public function mount($user)
    {
        $this->user_id = $user->id;
    }

    public function render()
    {
        $questions = Question::cacheFor(60 * 60)
            ->where('user_id', $this->user_id)
            ->latest()
            ->paginate(20);

        return view('livewire.user.questions', [
            'questions' => $questions,
        ]);
    }
}
