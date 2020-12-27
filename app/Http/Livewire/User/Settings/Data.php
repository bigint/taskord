<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\User;
use Livewire\Component;

class Data extends Component
{
    public User $user;
    public $confirming;

    public function mount($user)
    {
        $this->user = $user;
    }
}
