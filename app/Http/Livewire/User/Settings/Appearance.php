<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class Appearance extends Component
{
    public $listeners = [
        'toggledMode' => 'render',
    ];
    public User $user;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function toggleMode($mode)
    {
        if (auth()->user()->id === $this->user->id) {
            Cookie::queue('color_mode', $mode, config('session.lifetime'));
            $this->emit('toggledMode');
            loggy(request(), 'User', auth()->user(), 'Toggled appearance');

            return redirect()->route('user.settings.appearance');
        }

        return toast($this, 'error', config('taskord.toast.deny'));
    }

    public function render(): View
    {
        return view('livewire.user.settings.appearance');
    }
}
