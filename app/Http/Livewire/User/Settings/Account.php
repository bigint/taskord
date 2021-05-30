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

                return toast($this, 'success', 'Your are now beta member!');
            }

            loggy(request(), 'User', auth()->user(), 'Opted out from beta');

            return toast($this, 'success', 'Your are no longer a beta member!');
        }

        return toast($this, 'error', config('taskord.error.deny'));
    }

    public function enrollPrivate()
    {
        if (auth()->user()->id === $this->user->id) {
            if (! $this->user->is_patron) {
                toast($this, 'error', config('taskord.error.deny'));
            }
            $this->user->is_private = ! $this->user->is_private;
            $this->user->save();
            if ($this->user->is_private) {
                loggy(request(), 'User', auth()->user(), 'Enrolled as a private user');

                return toast($this, 'success', 'All your tasks are now private');
            }

            loggy(request(), 'User', auth()->user(), 'Enrolled as a public user');

            return toast($this, 'success', 'All your tasks are now public');
        }

        return toast($this, 'error', config('taskord.error.deny'));
    }

    public function updated($field)
    {
        $this->validateOnly($field, [
            'username' => ['required', 'min:2', 'max:20', 'alpha_dash', 'unique:users,username,'.$this->user->id, new ReservedSlug()],
            'email' => ['required', 'email', 'max:255', 'indisposable', 'unique:users,email,'.$this->user->id],
        ]);
    }

    public function updateAccount()
    {
        if (auth()->user()->id === $this->user->id) {
            $this->validate([
                'username' => ['required', 'min:2', 'max:20', 'alpha_dash', 'unique:users,username,'.$this->user->id, new ReservedSlug()],
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
        }

        return toast($this, 'error', config('taskord.error.deny'));
    }
}
