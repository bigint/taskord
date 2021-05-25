<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\User;
use App\Rules\ReservedSlug;
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
        if (auth()->user()->id === $this->user->id) {
            $this->user->is_beta = ! $this->user->is_beta;
            $this->user->save();
            if ($this->user->is_beta) {
                loggy(request(), 'User', auth()->user(), 'Enrolled to beta');

                toast($this, 'success', 'Your are now beta member!');
            } else {
                loggy(request(), 'User', auth()->user(), 'Opted out from beta');

                toast($this, 'success', 'Your are no longer a beta member!');
            }
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function enrollPrivate()
    {
        if (auth()->user()->id === $this->user->id) {
            if (! $this->user->is_patron) {
                toast($this, 'error', 'Forbidden!');
            }
            $this->user->is_private = ! $this->user->is_private;
            $this->user->save();
            if ($this->user->is_private) {
                loggy(request(), 'User', auth()->user(), 'Enrolled as a private user');

                toast($this, 'success', 'All your tasks are now private');
            } else {
                loggy(request(), 'User', auth()->user(), 'Enrolled as a public user');

                toast($this, 'success', 'All your tasks are now public');
            }
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function updated($field)
    {
        $this->validateOnly($field, [
            'username' => ['required', 'min:2', 'max:20', 'alpha_dash', 'unique:users,username,'.$this->user->id, new ReservedSlug],
            'email' => ['required', 'email', 'max:255', 'indisposable', 'unique:users,email,'.$this->user->id],
        ]);
    }

    public function updateAccount()
    {
        if (auth()->user()->id === $this->user->id) {
            $this->validate([
                'username' => ['required', 'min:2', 'max:20', 'alpha_dash', 'unique:users,username,'.$this->user->id, new ReservedSlug],
                'email' => ['required', 'email', 'max:255', 'indisposable', 'unique:users,email,'.$this->user->id],
            ]);

            if (auth()->user()->id === $this->user->id) {
                $this->user->username = $this->username;
                if ($this->email !== $this->user->email) {
                    $this->user->email_verified_at = null;
                    $this->user->sendEmailVerificationNotification();
                }
                $this->user->email = $this->email;
                $this->user->save();
                loggy(request(), 'User', auth()->user(), 'Updated account settings');

                toast($this, 'success', 'Your account has been updated!');
            }
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }
}
