<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\User;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Livewire\Component;

class Api extends Component
{
    public User $user;

    public $listeners = [
        'refreshApiToken' => 'render',
    ];

    public function mount($user)
    {
        $this->user = $user;
    }

    public function regenerateToken()
    {
        $throttler = Throttle::get(Request::instance(), 5, 5);
        $throttler->hit();
        if (count($throttler) > 10) {
            Helper::flagAccount(auth()->user());
        }
        if (! $throttler->check()) {
            loggy(request(), 'Throttle', auth()->user(), 'Rate limited while generating a API token');

            return toast($this, 'error', 'Your are rate limited, try again later!');
        }

        if (auth()->check()) {
            if (auth()->user()->id === $this->user->id) {
                auth()->user()->api_token = Str::random(60);
                auth()->user()->save();
                $this->emit('refreshApiToken');
                loggy(request(), 'User', auth()->user(), 'Created a new API key');

                return toast($this, 'success', 'New API key been generated successfully');
            } else {
                return toast($this, 'error', 'Forbidden!');
            }
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.user.settings.api');
    }
}
