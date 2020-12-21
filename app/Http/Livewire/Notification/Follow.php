<?php

namespace App\Http\Livewire\Notification;

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
            activity()
                ->withProperties(['type' => 'Throttle'])
                ->log('Rate limited while following the user');

            return $this->alert('warning', 'Your are rate limited, try again later!', [
                'showCancelButton' => true,
            ]);
        }

        if (Auth::check()) {
            if (Auth::user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!', [
                    'showCancelButton' => true,
                ]);
            }
            if (Auth::id() === $this->user->id) {
                return $this->alert('warning', 'You can\'t follow yourself!', [
                    'showCancelButton' => true,
                ]);
            } else {
                Auth::user()->toggleFollow($this->user);
                Auth::user()->touch();
                if (Auth::user()->isFollowing($this->user)) {
                    $this->user->notify(new Followed(Auth::user()));
                }
                activity()
                    ->withProperties(['type' => 'Notification'])
                    ->log('User toggle follow from notification U: @'.$this->user->username);
            }
        } else {
            return $this->alert('error', 'Forbidden!', [
                'showCancelButton' => true,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.notification.follow');
    }
}
