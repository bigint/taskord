<?php

namespace App\Http\Livewire\Milestone;

use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class CreateMilestone extends Component
{
    public $name;
    public $description;
    public $startDate;
    public $endDate;

    public function submit()
    {
        if (Gate::denies('create')) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->validate([
            'name' => ['required', 'min:3', 'max:150'],
            'description' => ['required', 'min:3', 'max:10000'],
        ]);

        $milestone = auth()->user()->milestones()->create([
            'name' => $this->name,
            'description' => $this->description,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
        ]);
        $this->emit('refreshMilestones');

        loggy(request(), 'Milestone', auth()->user(), "Created a new milestone | Milestone ID: {$milestone->id}");

        return redirect()->route('milestones.milestone', ['milestone' => $milestone]);
    }
}
