<?php

namespace App\Http\Livewire\User;

use App\Models\Question;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Questions extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public User $user;
    public $readyToLoad = false;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function loadQuestions()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        $questions = Question::cacheFor(60 * 60)
            ->where('user_id', $this->user->id)
            ->latest()
            ->paginate(10);

        return view('livewire.user.questions', [
            'questions' => $this->readyToLoad ? $questions : [],
        ]);
    }
}
