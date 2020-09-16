<?php

namespace App\Http\Livewire\User\Settings;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Password extends Component
{
    public $user;
    public $currentPassword;
    public $newPassword;
    public $confirmPassword;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function updated($field)
    {
        if (Auth::check()) {
            $this->validateOnly($field, [
                'currentPassword' => 'required',
                'newPassword' => 'required|min:8|pwned',
                'confirmPassword' => 'required|same:newPassword',
            ],
            [
                'newPassword.pwned' => 'This password has been pwned before',
            ]);
        }
    }

    public function updatePassword()
    {
        if (Auth::check()) {
            if (Auth::id() === $this->user->id) {
                $this->validate([
                    'currentPassword' => 'required',
                    'newPassword' => 'required|min:8|pwned',
                    'confirmPassword' => 'required|same:newPassword',
                ],
                [
                    'newPassword.pwned' => 'This password has been pwned before',
                ]);

                $user = Auth::user();

                if (! Hash::check($this->currentPassword, $user->password)) {
                    return session()->flash('error', 'Current password does not match!');
                }

                $user->password = Hash::make($this->newPassword);
                $user->save();

                return session()->flash('success', 'Your password has been changed!');
            } else {
                return session()->flash('error', 'Forbidden!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.user.settings.password');
    }
}
