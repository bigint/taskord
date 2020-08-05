<?php

namespace App\Http\Livewire\User\Settings;

use Auth;
use Livewire\Component;

class Account extends Component
{
    public $user;
    public $username;
    public $email;

    public function mount($user)
    {
        $this->user = $user;
        $this->username = $user->username;
        $this->email = $user->email;
    }

    public function enrollBeta()
    {
        if (Auth::check()) {
            if (Auth::id() === $this->user->id) {
                $this->user->isBeta = ! $this->user->isBeta;
                $this->user->save();
                if ($this->user->isBeta) {
                    session()->flash('success', 'Your are now beta member!');
                } else {
                    session()->flash('warning', 'Your are no longer a beta member!');
                }
            } else {
                return session()->flash('error', 'Forbidden!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function updated($field)
    {
        if (Auth::check()) {
            $this->validateOnly($field, [
                'username' => 'required|profanity|min:3|max:20|alpha_dash|unique:users,username,'.$this->user->id,
                'email' => 'required|email|max:255|unique:users,email,'.$this->user->id,
            ],
            [
                'username.profanity' => 'Please check your words!',
                'email.profanity' => 'Please check your words!',
            ]);
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function updateAccount()
    {
        if (Auth::check()) {
            $validatedData = $this->validate([
                'username' => 'required|profanity|min:3|max:20|alpha_dash|unique:users,username,'.$this->user->id,
                'email' => 'required|email|max:255|unique:users,email,'.$this->user->id,
            ],
            [
                'username.profanity' => 'Please check your words!',
                'email.profanity' => 'Please check your words!',
            ]);

            if (Auth::check() && Auth::id() === $this->user->id) {
                $this->user->username = $this->username;
                $this->user->email = $this->email;
                $this->user->save();

                return session()->flash('success', 'Your account has been updated!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.user.settings.account');
    }
}
