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
                    return $this->alert('error', 'Current password does not match!', [
                        'showCancelButton' => true,
                    ]);
                }

                $user->password = Hash::make($this->newPassword);
                $user->save();
                activity()
                    ->withProperties(['type' => 'User'])
                    ->log('Account password was changed');

                return $this->alert('success', 'Your password has been changed!', [
                    'showCancelButton' => true,
                ]);
            } else {
                return $this->alert('error', 'Forbidden!', [
                'showCancelButton' => true,
            ]);
            }
        } else {
            return $this->alert('error', 'Forbidden!', [
                'showCancelButton' => true,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.user.settings.password');
    }
}
