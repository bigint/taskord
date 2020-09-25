<?php

namespace App\Http\Livewire\User\Settings;

use GrahamCampbell\Throttle\Facades\Throttle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Livewire\Component;

class Api extends Component
{
    public $user;

    public $listeners = [
        'tokenRegenerated' => 'render',
    ];

    public function mount($user)
    {
        $this->user = $user;
    }

    public function regenerateToken()
    {
        $throttler = Throttle::get(Request::instance(), 5, 5);
        $throttler->hit();
        if (! $throttler->check()) {
            return session()->flash('error', 'Your are rate limited, try again later!');
        }

        if (Auth::check()) {
            if (Auth::id() === $this->user->id) {
                $token = Str::random(60);
                Auth::user()->api_token = $token;
                Auth::user()->save();
                $this->emit('tokenRegenerated');
            } else {
                return session()->flash('error', 'Forbidden!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.user.settings.api');
    }
}
