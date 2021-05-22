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

        if (auth()->check()) {
            if (! auth()->user()->hasVerifiedEmail()) {
                return toast($this, 'error', 'Your email is not verified!');
            }
            if (auth()->user()->isFlagged) {
                return toast($this, 'error', 'Your account is flagged!');
            }
            if (auth()->user()->id === $this->meetup->user_id) {
                return toast($this, 'error', 'You can\'t RSVP your own meetup!');
            } else {
                auth()->user()->toggleSubscribe($this->meetup);
                $this->meetup->refresh();
                auth()->user()->touch();
            }
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }
}
