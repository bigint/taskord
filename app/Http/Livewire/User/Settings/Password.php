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

    public function mount()
    {
        $this->user = auth()->user();
    }

    public function updated($field)
    {
        $this->validateOnly($field, [
            'currentPassword' => ['required'],
            'newPassword'     => ['required', 'string', PasswordRule::min(8)->uncompromised()],
            'confirmPassword' => ['required', 'same:newPassword'],
        ]);
    }

    public function updatePassword()
    {
        $this->validate([
            'currentPassword' => ['required'],
            'newPassword'     => ['required', 'string', PasswordRule::min(8)->uncompromised()],
            'confirmPassword' => ['required', 'same:newPassword'],
        ]);

        if (! Hash::check($this->currentPassword, auth()->user()->password)) {
            toast($this, 'error', 'Current password does not match!');
        }

        auth()->user()->password = Hash::make($this->newPassword);
        auth()->user()->save();
        loggy(request(), 'User', auth()->user(), 'Changed account password');

        return toast($this, 'success', 'Your password has been changed!');
    }
}
