<?php

namespace App\Http\Livewire\User;

use App\Models\Answer;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Answers extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public User $user;
    public $readyToLoad = false;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function loadAnswers()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        $answers = Answer::cacheFor(60 * 60)
            ->where('user_id', $this->user->id)
            ->latest()
            ->paginate(10);

        return view('livewire.user.answers', [
            'answers' => $this->readyToLoad ? $answers : [],
        ]);
    }
}
