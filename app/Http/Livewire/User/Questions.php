<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Questions extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public User $user;
    public $ready_to_load = false;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function loadQuestions()
    {
        $this->ready_to_load = true;
    }

    public function getQuestions()
    {
        return $this->user->questions()
            ->latest()
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.user.questions', [
            'questions' => $this->ready_to_load ? $this->getQuestions() : [],
        ]);
    }
}
