<?php

namespace App\Http\Livewire\Onboarding;

use Livewire\Component;

class Profile extends Component
{
    public $user;
    public $firstname;
    public $lastname;
    public $username;
    public $bio;

    public function mount($user)
    {
        $this->user = $user;
        $this->firstname = $user->firstname;
        $this->lastname = $user->lastname;
        $this->username = $user->username;
        $this->bio = $user->bio;
    }

    public function render()
    {
        return view('livewire.onboarding.profile');
    }
}
