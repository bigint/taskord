<?php

namespace App\Http\Livewire\User;

use App\Notifications\Followed;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class Follow extends Component
{
    public $user;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function followUser()
    {
        $throttler = Throttle::get(Request::instance(), 10, 5);
        $throttler->hit();
        if (count($throttler) > 20) {
            Helper::flagAccount(Auth::user());
        }
        if (! $throttler->check()) {
            return session()->flash('error', 'Please slow down!');
        }

        if (Auth::check()) {
            if (Auth::user()->isFlagged) {
                return session()->flash('error', 'Your account is flagged!');
            }
            if (Auth::id() === $this->user->id) {
                return session()->flash('error', 'You can\'t follow yourself!');
            } else {
                Auth::user()->toggleFollow($this->user);
                $this->user->refresh();
                Auth::user()->touch();
                if (Auth::user()->isFollowing($this->user)) {
                    $this->user->notify(new Followed(Auth::user()));
                }
                activity()
                    ->withProperties(['type' => 'User'])
                    ->log('@' . Auth::user()->username . ' toggle follow @' . $this->user->username);
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.user.follow');
    }
}
