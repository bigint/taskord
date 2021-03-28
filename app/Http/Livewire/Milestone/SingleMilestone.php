<?php

namespace App\Http\Livewire\Milestone;

use App\Models\Milestone;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class SingleMilestone extends Component
{
    public Milestone $milestone;
    public $type;
    public $confirming;

    public function mount($milestone, $type)
    {
        $this->milestone = $milestone;
        $this->type = $type;
    }

    public function togglePraise()
    {
        $throttler = Throttle::get(Request::instance(), 20, 5);
        $throttler->hit();
        if (count($throttler) > 30) {
            Helper::flagAccount(auth()->user());
        }
        if (! $throttler->check()) {
            loggy(request()->ip(), 'Throttle', auth()->user(), 'Rate limited while praising the milestone');

            return $this->alert('error', 'Your are rate limited, try again later!');
        }

        if (Auth::check()) {
            if (! auth()->user()->hasVerifiedEmail()) {
                return $this->alert('warning', 'Your email is not verified!');
            }

            if (auth()->user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!');
            }
            if (auth()->user()->id === $this->milestone->user->id) {
                return $this->alert('warning', 'You can\'t praise your own milestone!');
            }
            Helper::togglePraise($this->milestone, 'MILESTONE');
            loggy(request()->ip(), 'Milestone', auth()->user(), 'Toggled milestone praise | Milestone ID: '.$this->milestone->id);
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function hide()
    {
        if (Auth::check()) {
            if (auth()->user()->isStaff and auth()->user()->staffShip) {
                Helper::hide($this->milestone);
                loggy(request()->ip(), 'Admin', auth()->user(), 'Toggled hide milestone | Milestone ID: '.$this->milestone->id);

                return $this->alert('success', 'Milestone is hidden from public!');
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function confirmDelete()
    {
        $this->confirming = $this->milestone->id;
    }

    public function deleteMilestone()
    {
        if (Auth::check()) {
            if (auth()->user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!');
            }

            if (auth()->user()->staffShip or auth()->user()->id === $this->milestone->user_id) {
                loggy(request()->ip(), 'Milestone', auth()->user(), 'Deleted a milestone | Milestone ID: '.$this->milestone->id);
                $this->milestone->delete();
                auth()->user()->touch();
                $this->flash('success', 'Milestone has been deleted successfully!');

                return redirect()->route('milestones.home');
            } else {
                $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }
}
