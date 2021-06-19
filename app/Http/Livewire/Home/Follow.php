<?php

namespace App\Http\Livewire\Home;

use App\Models\User;
use App\Notifications\Followed;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class Follow extends Component
{
    use WithRateLimiting;

    public User $user;
    public $showText;

    public function mount($user, $showText)
    {
        $this->showText = $showText;
        $this->user = $user;
    }

    public function toggleFollow()
    {
        try {
            $this->rateLimit(50);
        } catch (TooManyRequestsException $exception) {
            return toast($this, 'error', config('taskord.error.rate-limit'));
        }

        if (Gate::denies('user.follow', $this->user)) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        auth()->user()->toggleFollow($this->user);

        if (auth()->user()->isFollowing($this->user)) {
            $this->emitUp('refreshSuggestions');
            $this->user->notify(new Followed(auth()->user()));
            loggy(request(), 'User', auth()->user(), "Followed the user | Username: @{$this->user->username}");

            return toast($this, 'success', 'Followed successfully!');
        }
        $this->emitUp('refreshSuggestions');
        loggy(request(), 'User', auth()->user(), "Unfollowed the user | Username: @{$this->user->username}");

        return toast($this, 'success', 'Unfollowed successfully!');
    }
}
