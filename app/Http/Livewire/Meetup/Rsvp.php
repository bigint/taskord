<?php

namespace App\Http\Livewire\Meetup;

use App\Models\Meetup;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Auth;
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
            Helper::flagAccount(Auth::user());
        }
        if (! $throttler->check()) {
            activity()
                ->withProperties(['type' => 'Throttle'])
                ->log('Rate limited while toggling RSVP');

            return $this->alert('error', 'Your are rate limited, try again later!', [
                'showCancelButton' =>  false,
            ]);
        }

        if (Auth::check()) {
            if (! Auth::user()->hasVerifiedEmail()) {
                return $this->alert('warning', 'Your email is not verified!', [
                    'showCancelButton' =>  false,
                ]);
            }
            if (Auth::user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!', [
                    'showCancelButton' =>  false,
                ]);
            }
            if (Auth::id() === $this->meetup->user_id) {
                return $this->alert('warning', 'You can\'t RSVP your own meetup!', [
                    'showCancelButton' =>  false,
                ]);
            } else {
                Auth::user()->toggleSubscribe($this->meetup);
                $this->meetup->refresh();
                Auth::user()->touch();
            }
        } else {
            return $this->alert('error', 'Forbidden!', [
                'showCancelButton' =>  false,
            ]);
        }
    }
}
