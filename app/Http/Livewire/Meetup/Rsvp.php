<?php

namespace App\Http\Livewire\Meetup;

use App\Models\Meetup;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class Rsvp extends Component
{
    public Meetup $meetup;

    public function mount($meetup)
    {
        $this->meetup = $meetup;
    }

    public function toggleRSVP()
    {
        $throttler = Throttle::get(Request::instance(), 20, 5);
        $throttler->hit();
        if (count($throttler) > 30) {
            Helper::flagAccount(auth()->user());
        }
        if (! $throttler->check()) {
            loggy(request(), 'Throttle', auth()->user(), 'Rate limited while toggling the RSVP');

            return toast($this, 'error', 'Your are rate limited, try again later!');
        }

        if (Gate::denies('praise', $this->meetup)) {
            return toast($this, 'error', "Oops! You can't perform this action");
        }

        auth()->user()->toggleSubscribe($this->meetup);
        $this->meetup->refresh();

        return auth()->user()->touch();
    }
}
