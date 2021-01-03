<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Account extends Component
{
    public User $user;
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
            if (auth()->user()->id === $this->user->id) {
                $this->user->isBeta = ! $this->user->isBeta;
                $this->user->save();
                if ($this->user->isBeta) {
                    loggy('User', auth()->user(), 'Enrolled to beta');

                    return $this->alert('success', 'Your are now beta member!');
                } else {
                    loggy('User', auth()->user(), 'Opted out from beta');

                    return $this->alert('success', 'Your are no longer a beta member!');
                }
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function enrollPrivate()
    {
        if (Auth::check()) {
            if (auth()->user()->id === $this->user->id) {
                if (! $this->user->isPatron) {
                    return $this->alert('error', 'Forbidden!');
                }
                $this->user->isPrivate = ! $this->user->isPrivate;
                $this->user->save();
                if ($this->user->isPrivate) {
                    loggy('User', auth()->user(), 'Enrolled as a private user');

                    return $this->alert('success', 'All your tasks are now private');
                } else {
                    loggy('User', auth()->user(), 'Enrolled as a public user');

                    return $this->alert('success', 'All your tasks are now public');
                }
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function updated($field)
    {
        if (Auth::check()) {
            $this->validateOnly($field, [
                'username' => 'required|min:2|max:20|alpha_dash|unique:users,username,'.$this->user->id,
                'email' => 'required|email|max:255|indisposable|unique:users,email,'.$this->user->id,
            ]);
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function updateAccount()
    {
        if (Auth::check()) {
            if (auth()->user()->id === $this->user->id) {
                $this->validate([
                    'username' => 'required|min:2|max:20|alpha_dash|unique:users,username,'.$this->user->id,
                    'email' => 'required|email|max:255|indisposable|unique:users,email,'.$this->user->id,
                ]);

                if ($this->email !== $this->user->email) {
                    $this->user->email_verified_at = null;
                }

                if (Auth::check() && auth()->user()->id === $this->user->id) {
                    $this->user->username = $this->username;
                    $this->user->email = $this->email;
                    $this->user->save();
                    $this->user->sendEmailVerificationNotification();
                    loggy('User', auth()->user(), 'Updated account settings');

                    return $this->alert('success', 'Your account has been updated!');
                }
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }
}
