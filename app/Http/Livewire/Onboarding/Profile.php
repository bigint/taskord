<?php

namespace App\Http\Livewire\Onboarding;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

    public function updated($field)
    {
        if (Auth::check()) {
            if (auth()->user()->id === $this->user->id) {
                $this->validateOnly($field, [
                    'username' => 'required|min:2|max:20|alpha_dash|unique:users,username,'.$this->user->id,
                ]);
            }
        }
    }

    public function submit()
    {
        if (Auth::check()) {
            if (auth()->user()->id === $this->user->id) {
                $this->validate([
                    'username' => 'required|min:2|max:20|alpha_dash|unique:users,username,'.$this->user->id,
                ]);
            }
        }
    }

    public function render()
    {
        return view('livewire.onboarding.profile');
    }
}
