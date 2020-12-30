<?php

namespace App\Http\Livewire\Notification;

use App\Models\User;
use App\Notifications\Followed;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class Follow extends Component
{
    public User $user;

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
            activity()
                ->withProperties(['type' => 'Throttle'])
                ->log('Rate limited while following the user');

            return $this->alert('error', 'Your are rate limited, try again later!');
        }

        if (Auth::check()) {
            if (Auth::user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!');
            }
            if (Auth::id() === $this->user->id) {
                return $this->alert('warning', 'You can\'t follow yourself!');
            } else {
                Auth::user()->toggleFollow($this->user);
                Auth::user()->touch();
                if (Auth::user()->isFollowing($this->user)) {
                    $this->user->notify(new Followed(Auth::user()));
                }
                activity()
                    ->withProperties(['type' => 'Notification'])
                    ->log('Toggled user follow | User ID: @'.$this->user->username);
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }
}
