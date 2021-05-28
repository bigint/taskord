<?php

namespace App\Http\Livewire\Milestone;

use App\Models\Milestone;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Gate;
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

        if (Gate::denies('praise', $this->milestone)) {
            return toast($this, 'error', "Oops! You can't perform this action");
        }

        Helper::togglePraise($this->milestone, 'MILESTONE');

        return loggy(request(), 'Milestone', auth()->user(), 'Toggled milestone praise | Milestone ID: '.$this->milestone->id);
    }

    public function hide()
    {
        if (Gate::denies('staff_mode')) {
            return toast($this, 'error', "Oops! You can't perform this action");
        }

        Helper::hide($this->milestone);
        loggy(request(), 'Staff', auth()->user(), 'Toggled hide milestone | Milestone ID: '.$this->milestone->id);

        return toast($this, 'success', 'Milestone is hidden from public!');
    }

    public function toggleStatus()
    {
        if (! auth()->check()) {
            return toast($this, 'error', "Oops! You can't perform this action");
        }

        if ($this->milestone->status) {
            $this->milestone->status = false;
            $this->milestone->save();
            loggy(request(), 'Milestone', auth()->user(), 'Closed the milestone | Milestone ID: '.$this->milestone->id);

            return redirect()->route('milestones.milestone', ['milestone' => $this->milestone]);
        }

        $this->milestone->status = true;
        $this->milestone->save();
        loggy(request(), 'Milestone', auth()->user(), 'Opened the milestone | Milestone ID: '.$this->milestone->id);

        return redirect()->route('milestones.milestone', ['milestone' => $this->milestone]);
    }

    public function deleteMilestone()
    {
        if (Gate::denies('act', $this->milestone)) {
            return toast($this, 'error', "Oops! You can't perform this action");
        }

        loggy(request(), 'Milestone', auth()->user(), 'Deleted a milestone | Milestone ID: '.$this->milestone->id);
        $this->milestone->delete();
        auth()->user()->touch();

        return redirect()->route('milestones.opened');
    }
}
