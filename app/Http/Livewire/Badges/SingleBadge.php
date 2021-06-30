<?php

namespace App\Http\Livewire\Badges;

use App\Models\ProfileBadge;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Livewire\Component;

class SingleBadge extends Component
{
    use WithRateLimiting;

    public ProfileBadge $badge;

    public function mount($badge)
    {
        $this->badge = $badge;
    }

    public function toggleAddBadge()
    {
        try {
            $this->rateLimit(50);
        } catch (TooManyRequestsException $exception) {
            return toast($this, 'error', config('taskord.error.rate-limit'));
        }

        if (Gate::denies('like/subscribe', $this->badge)) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        if ($this->badge->isSubscribedBy(auth()->user())) {
            auth()->user()->unsubscribe($this->badge);
            toast($this, 'success', 'Badge has been removed from your profile successfully');
        } else {
            auth()->user()->subscribe($this->badge);
            toast($this, 'success', 'Badge has been added to your profile successfully');
        }

        $this->emit('badgeAdded');

        return loggy(request(), 'Badge', auth()->user(), "Toggled badge add | Badge ID: {$this->badge->id}");
    }

    public function render(): View
    {
        return view('livewire.badges.single-badge');
    }
}
