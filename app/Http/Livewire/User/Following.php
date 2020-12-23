<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Models\User;

class Following extends Component
{
    public User $user;

    public function mount($user)
    {
        $this->user = $user;
    }
}
