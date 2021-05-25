<?php

namespace App\Http\Livewire\Milestone;

use App\Models\Milestone;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class SingleMilestone extends Component
{
    public Milestone $milestone;
    public $type;

    public function mount($milestone, $type)
    {
        $this->milestone = $milestone;
        $this->type = $type;
    }

    public function togglePraise()
    {
        $throttler = Throttle::get(Request::instance(), 30, 5);
        $throttler->hit();
        if (count($throttler) > 30) {
            Helper::flagAccount(auth()->user());
        }
        if (! $throttler->check()) {
            loggy(request(), 'Throttle', auth()->user(), 'Rate limited while praising the milestone');

            return toast($this, 'error', 'Your are rate limited, try again later!');
        }

        if (! auth()->check()) {
            return toast($this, 'error', 'Forbidden!');
        }

        if (! auth()->user()->hasVerifiedEmail()) {
            return toast($this, 'error', 'Your email is not verified!');
        }

        if (auth()->user()->isFlagged) {
            return toast($this, 'error', 'Your account is flagged!');
        }
        if (auth()->user()->id === $this->milestone->user->id) {
            return toast($this, 'error', 'You can\'t praise your own milestone!');
        }
        Helper::togglePraise($this->milestone, 'MILESTONE');
        loggy(request(), 'Milestone', auth()->user(), 'Toggled milestone praise | Milestone ID: '.$this->milestone->id);
    }

    public function hide()
    {
        if (! auth()->check()) {
            return toast($this, 'error', 'Forbidden!');
        }

        if (auth()->user()->isStaff and auth()->user()->staffShip) {
            Helper::hide($this->milestone);
            loggy(request(), 'Staff', auth()->user(), 'Toggled hide milestone | Milestone ID: '.$this->milestone->id);

            return toast($this, 'success', 'Milestone is hidden from public!');
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function toggleStatus()
    {
        if (! auth()->check()) {
            return toast($this, 'error', 'Forbidden!');
        }

        if ($this->milestone->status) {
            $this->milestone->status = false;
            $this->milestone->save();
            loggy(request(), 'Milestone', auth()->user(), 'Closed the milestone | Milestone ID: '.$this->milestone->id);

            return redirect()->route('milestones.milestone', ['milestone' => $this->milestone]);
        } else {
            $this->milestone->status = true;
            $this->milestone->save();
            loggy(request(), 'Milestone', auth()->user(), 'Opened the milestone | Milestone ID: '.$this->milestone->id);

            return redirect()->route('milestones.milestone', ['milestone' => $this->milestone]);
        }
    }

    public function deleteMilestone()
    {
        if (! auth()->check()) {
            return toast($this, 'error', 'Forbidden!');
        }

        if (auth()->user()->isFlagged) {
            return toast($this, 'error', 'Your account is flagged!');
        }

        if (auth()->user()->staffShip or auth()->user()->id === $this->milestone->user_id) {
            loggy(request(), 'Milestone', auth()->user(), 'Deleted a milestone | Milestone ID: '.$this->milestone->id);
            $this->milestone->delete();
            auth()->user()->touch();

            return redirect()->route('milestones.opened');
        } else {
            toast($this, 'error', 'Forbidden!');
        }
    }
}
