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
        if (auth()->check()) {
            if (auth()->user()->id === $this->user->id) {
                $this->user->isBeta = ! $this->user->isBeta;
                $this->user->save();
                if ($this->user->isBeta) {
                    loggy(request(), 'User', auth()->user(), 'Enrolled to beta');

                    return $this->dispatchBrowserEvent('toast', [
                        'type' => 'success',
                        'body' => 'Your are now beta member!',
                    ]);
                } else {
                    loggy(request(), 'User', auth()->user(), 'Opted out from beta');

                    return $this->dispatchBrowserEvent('toast', [
                        'type' => 'success',
                        'body' => 'Your are no longer a beta member!',
                    ]);
                }
            } else {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'Forbidden!',
                ]);
            }
        } else {
            return $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Forbidden!',
            ]);
        }
    }

    public function enrollPrivate()
    {
        if (auth()->check()) {
            if (auth()->user()->id === $this->user->id) {
                if (! $this->user->isPatron) {
                    return $this->dispatchBrowserEvent('toast', [
                        'type' => 'error',
                        'body' => 'Forbidden!',
                    ]);
                }
                $this->user->isPrivate = ! $this->user->isPrivate;
                $this->user->save();
                if ($this->user->isPrivate) {
                    loggy(request(), 'User', auth()->user(), 'Enrolled as a private user');

                    return $this->dispatchBrowserEvent('toast', [
                        'type' => 'success',
                        'body' => 'All your tasks are now private',
                    ]);
                } else {
                    loggy(request(), 'User', auth()->user(), 'Enrolled as a public user');

                    return $this->dispatchBrowserEvent('toast', [
                        'type' => 'success',
                        'body' => 'All your tasks are now public',
                    ]);
                }
            } else {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'Forbidden!',
                ]);
            }
        } else {
            return $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Forbidden!',
            ]);
        }
    }

    public function updated($field)
    {
        if (auth()->check()) {
            $this->validateOnly($field, [
                'username' => ['required', 'min:2', 'max:20', 'alpha_dash', 'unique:users,username,'.$this->user->id, new ReservedSlug],
                'email' => ['required', 'email', 'max:255', 'indisposable', 'unique:users,email,'.$this->user->id],
            ]);
        } else {
            return $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Forbidden!',
            ]);
        }
    }

    public function updateAccount()
    {
        if (auth()->check()) {
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

                    return $this->dispatchBrowserEvent('toast', [
                        'type' => 'success',
                        'body' => 'Your account has been updated!',
                    ]);
                }
            } else {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'Forbidden!',
                ]);
            }
        } else {
            return $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Forbidden!',
            ]);
        }
    }
}
