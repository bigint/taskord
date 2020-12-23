<?php

namespace App\Http\Livewire\User;

use App\Models\Answer;
use Livewire\Component;
use App\Models\User;

class Answers extends Component
{
    public User $user;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function render()
    {
        $answers = Answer::cacheFor(60 * 60)
            ->where('user_id', $this->user->id)
            ->latest()
            ->paginate(10);

        return view('livewire.user.answers', [
            'answers' => $answers,
        ]);
    }
}
