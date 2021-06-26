<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Answers extends Component
{
    use WithPagination;

    public User $user;
    public $readyToLoad = false;
    protected $paginationTheme = 'bootstrap';

    public function mount($user)
    {
        $this->user = $user;
    }

    public function loadAnswers()
    {
        $this->readyToLoad = true;
    }

    public function getAnswers()
    {
        return $this->user->answers()
            ->with('question.user')
            ->latest()
            ->paginate(10);
    }

    public function render(): View
    {
        return view('livewire.user.answers', [
            'answers' => $this->readyToLoad ? $this->getAnswers() : [],
        ]);
    }
}
