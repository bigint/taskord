<?php

namespace App\Http\Livewire\User;

use Livewire\Component;

class Status extends Component
{
    public $user;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.user.status');
    }
}
