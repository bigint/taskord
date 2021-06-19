<?php

namespace App\Http\Livewire\Milestone;

use App\Models\Milestone;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class EditMilestone extends Component
{
    public Milestone $milestone;
    public $name;
    public $description;
    public $startDate;
    public $endDate;

    protected $rules = [
        'name' => ['required', 'min:3', 'max:150'],
        'description' => ['required', 'min:3', 'max:10000'],
    ];

    public function mount($milestone)
    {
        $this->milestone = $milestone;
        $this->name = $milestone->name;
        $this->description = $milestone->description;
        $this->startDate = $milestone->start_date ? carbon($milestone->start_date)->format('Y-m-d') : null;
        $this->endDate = $milestone->end_date ? carbon($milestone->end_date)->format('Y-m-d') : null;
    }

    public function updated($field)
    {
        if (! auth()->check()) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->validateOnly($field);
    }

    public function submit()
    {
        if (Gate::denies('edit/delete', $this->milestone)) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->validate();

        $milestone = Milestone::where('id', $this->milestone->id)->firstOrFail();

        $milestone->name = $this->name;
        $milestone->description = $this->description;
        $milestone->start_date = $this->startDate ? $this->startDate : null;
        $milestone->end_date = $this->startDate ? $this->endDate : null;
        $milestone->save();
        $this->emit('refreshMilestones');

        loggy(request(), 'Milestone', auth()->user(), "Updated a milestone | Milestone ID: {$milestone->id}");

        return redirect()->route('milestones.milestone', ['milestone' => $milestone]);
    }
}
