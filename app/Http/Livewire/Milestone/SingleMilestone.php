<?php

namespace App\Http\Livewire\Milestone;

use App\Models\Milestone;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Helper;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class SingleMilestone extends Component
{
    use WithRateLimiting;

    public Milestone $milestone;
    public $type;

    public function mount($milestone, $type)
    {
        $this->milestone = $milestone;
        $this->type = $type;
    }

    public function toggleLike()
    {
        try {
            $this->rateLimit(50);
        } catch (TooManyRequestsException $exception) {
            return toast($this, 'error', config('taskord.error.rate-limit'));
        }

        if (Gate::denies('like/subscribe', $this->milestone)) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        Helper::toggleLike($this->milestone, 'MILESTONE');
        $this->emit('milestoneLiked');

        return loggy(request(), 'Milestone', auth()->user(), "Toggled milestone like | Milestone ID: {$this->milestone->id}");
    }

    public function hide()
    {
        if (Gate::denies('staff.ops')) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        Helper::hide($this->milestone);
        $this->emit('milestonesHidden');
        loggy(request(), 'Staff', auth()->user(), "Toggled hide milestone | Milestone ID: {$this->milestone->id}");

        return toast($this, 'success', 'Milestone is hidden from public!');
    }

    public function toggleStatus()
    {
        if (! auth()->check()) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        if ($this->milestone->status) {
            $this->milestone->status = false;
            $this->milestone->save();
            loggy(request(), 'Milestone', auth()->user(), "Closed the milestone | Milestone ID: {$this->milestone->id}");

            return redirect()->route('milestones.milestone', ['milestone' => $this->milestone]);
        }

        $this->milestone->status = true;
        $this->milestone->save();
        loggy(request(), 'Milestone', auth()->user(), "Opened the milestone | Milestone ID: {$this->milestone->id}");

        return redirect()->route('milestones.milestone', ['milestone' => $this->milestone]);
    }

    public function deleteMilestone()
    {
        if (Gate::denies('edit/delete', $this->milestone)) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        loggy(request(), 'Milestone', auth()->user(), "Deleted a milestone | Milestone ID: {$this->milestone->id}");
        $this->milestone->delete();
        $this->emit('refreshMilestones');

        return redirect()->route('milestones.opened');
    }
}
