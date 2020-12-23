<?php

namespace App\Http\Livewire\User;

use App\Models\Question;
use App\Models\User;
use Livewire\Component;

class Questions extends Component
{
    public User $user;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function render()
    {
        $questions = Question::cacheFor(60 * 60)
            ->where('user_id', $this->user->id)
            ->latest()
            ->paginate(10);

        return view('livewire.user.questions', [
            'questions' => $questions,
        ]);
    }
}
