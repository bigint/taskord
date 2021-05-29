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
                $this->user->dark_mode = false;
                $this->user->save();
                loggy(request(), 'User', auth()->user(), 'Disabled dark mode');

                return redirect()->route('user.settings.appearance');
            }
            $this->user->dark_mode = true;
            $this->user->save();
            loggy(request(), 'User', auth()->user(), 'Enabled dark mode');

            return redirect()->route('user.settings.appearance');
        }

        return toast($this, 'error', config('taskord.error.deny'));
    }
}
