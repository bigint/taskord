<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\User;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Component;

class Api extends Component
{
    use WithRateLimiting;

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
        try {
            $this->rateLimit(50);
        } catch (TooManyRequestsException $exception) {
            return toast($this, 'error', config('taskord.error.rate-limit'));
        }

        if (auth()->user()->id === $this->user->id) {
            auth()->user()->api_token = Str::random(60);
            auth()->user()->save();
            $this->emit('refreshApiToken');
            loggy(request(), 'User', auth()->user(), 'Created a new API key');

            return toast($this, 'success', 'New API key been generated successfully');
        }

        return toast($this, 'error', config('taskord.toast.deny'));
    }

    public function render(): View
    {
        return view('livewire.user.settings.api');
    }
}
