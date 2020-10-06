<?php

namespace App\Http\Livewire\Meetup;

use GrahamCampbell\Throttle\Facades\Throttle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class Rsvp extends Component
{
    public $meetup;

    public function mount($meetup)
    {
        $this->meetup = $meetup;
    }

    public function toggleRSVP()
    {
        $throttler = Throttle::get(Request::instance(), 20, 5);
        $throttler->hit();
        if (! $throttler->check()) {
            return session()->flash('error', 'Please slow down!');
        }

        if (Auth::check()) {
            if (! Auth::user()->hasVerifiedEmail()) {
                return session()->flash('error', 'Your email is not verified!');
            }
            if (Auth::user()->isFlagged) {
                return session()->flash('error', 'Your account is flagged!');
            }
            if (Auth::id() === $this->meetup->user_id) {
                return session()->flash('error', 'You can\'t RSVP your own meetup!');
            } else {
                Auth::user()->toggleSubscribe($this->meetup);
                //$this->meetup->refresh();
                Auth::user()->touch();
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.meetup.rsvp');
    }
}
