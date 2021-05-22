<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Livewire\Component;

class Password extends Component
{
    public User $user;
    public $currentPassword;
    public $newPassword;
    public $confirmPassword;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function updated($field)
    {
        if (auth()->check()) {
            $this->validateOnly($field, [
                'currentPassword' => ['required'],
                'newPassword' => ['required', 'string', PasswordRule::min(8)->uncompromised()],
                'confirmPassword' => ['required', 'same:newPassword'],
            ]);
        } else {
            toast($this, 'error', 'Forbidden!');
        }
    }

    public function updatePassword()
    {
        if (auth()->check()) {
            if (auth()->user()->id === $this->user->id) {
                $this->validate([
                    'currentPassword' => ['required'],
                    'newPassword' => ['required', 'string', PasswordRule::min(8)->uncompromised()],
                    'confirmPassword' => ['required', 'same:newPassword'],
                ]);

                if (! Hash::check($this->currentPassword, auth()->user()->password)) {
                    return $this->dispatchBrowserEvent('toast', [
                        'type' => 'error',
                        'body' => 'Current password does not match!',
                    ]);
                }

                auth()->user()->password = Hash::make($this->newPassword);
                auth()->user()->save();
                loggy(request(), 'User', auth()->user(), 'Changed account password');

                return toast($this, 'success', 'Your password has been changed!');
            } else {
                return toast($this, 'error', 'Forbidden!');
            }
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }
}
