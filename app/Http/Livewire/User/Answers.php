<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Answers extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public User $user;
    public $ready_to_load = false;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function loadAnswers()
    {
        $this->ready_to_load = true;
    }

    public function getAnswers()
    {
        return $this->user->answers()
            ->latest()
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.user.answers', [
            'answers' => $this->ready_to_load ? $this->getAnswers() : [],
        ]);
    }
}
