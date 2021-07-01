<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\User;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\View;
use Livewire\Component;

class Appearance extends Component
{
    public $listeners = [
        'toggledMode' => 'render',
    ];
    public User $user;

    public function mount()
    {
        $this->user = auth()->user();
    }

    public function toggleMode($mode)
    {
        Cookie::queue('color_mode', $mode, config('session.lifetime'));
        $this->emit('toggledMode');
        loggy(request(), 'User', auth()->user(), 'Toggled appearance');

        return redirect()->route('user.settings.appearance');
    }

    public function render(): View
    {
        return view('livewire.user.settings.appearance');
    }
}
