<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Following extends Component
{
    use WithPagination;

    public User $user;
    public $followings;

    public function mount($user)
    {
        $this->user = $user;
        $this->followings = $user->followings;
    }
}
