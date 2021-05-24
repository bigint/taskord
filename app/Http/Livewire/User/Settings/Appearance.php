<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\User;
use Livewire\Component;

class Appearance extends Component
{
    public User $user;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function toggleMode($mode)
    {
        if (auth()->user()->id === $this->user->id) {
            if ($mode === 'light') {
                $this->user->darkMode = false;
                $this->user->save();
                loggy(request(), 'User', auth()->user(), 'Disabled dark mode');

                return redirect()->route('user.settings.appearance');
            } else {
                $this->user->darkMode = true;
                $this->user->save();
                loggy(request(), 'User', auth()->user(), 'Enabled dark mode');

                return redirect()->route('user.settings.appearance');
            }
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }
}
