<?php

namespace App\Http\Livewire\Meetups;

use App\Models\Meetup;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class SingleMeetup extends Component
{
    use WithRateLimiting;

    public $listeners = [
        'refreshMeetup' => 'render',
    ];

    public Meetup $meetup;

    public function mount($meetup)
    {
        $this->meetup = $meetup;
    }

    public function toggleRSVP()
    {
        try {
            $this->rateLimit(50);
        } catch (TooManyRequestsException $exception) {
            return toast($this, 'error', config('taskord.error.rate-limit'));
        }

        if (Gate::denies('like/subscribe', $this->meetup)) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        auth()->user()->toggleSubscribe($this->meetup);

        return $this->emitSelf('refreshMeetup');
    }

    public function render()
    {
        return view('livewire.meetups.single-meetup');
    }
}
