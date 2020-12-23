<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;

class Followers extends Component
{
    public User $user;

    public function mount($user)
    {
        $this->user = $user;
    }
}
