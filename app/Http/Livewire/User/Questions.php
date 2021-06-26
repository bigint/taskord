<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Questions extends Component
{
    use WithPagination;

    public User $user;
    public $readyToLoad = false;
    protected $paginationTheme = 'bootstrap';

    public function mount($user)
    {
        $this->user = $user;
    }

    public function loadQuestions()
    {
        $this->readyToLoad = true;
    }

    public function getQuestions()
    {
        return $this->user->questions()
            ->with('answers.user')
            ->latest()
            ->paginate(10);
    }

    public function render(): View
    {
        return view('livewire.user.questions', [
            'questions' => $this->readyToLoad ? $this->getQuestions() : [],
        ]);
    }
}
