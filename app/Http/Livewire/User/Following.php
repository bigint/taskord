<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;

class Following extends Component
{
    public User $user;
    public $followings;

    public function mount($user)
    {
        $this->user = $user;
        $this->followings = $user->followings;
    }
}
