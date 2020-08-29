<?php

namespace App\Http\Livewire\User\Settings;

use Livewire\Component;

class Integrations extends Component
{
    public $user;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.user.settings.integrations');
    }
}
