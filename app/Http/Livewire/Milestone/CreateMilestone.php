<?php

namespace App\Http\Livewire\Milestone;

use App\Models\Milestone;
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
            return toast($this, 'error', config('taskord.error.deny'));
        }

        $this->validate([
            'name' => ['required', 'min:5', 'max:150'],
            'description' => ['required', 'min:3', 'max:10000'],
        ]);

        $milestone = Milestone::create([
            'user_id' =>  auth()->user()->id,
            'name' => $this->name,
            'description' => $this->description,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
        ]);
        auth()->user()->touch();

        loggy(request(), 'Milestone', auth()->user(), 'Created a new milestone | Milestone ID: '.$milestone->id);

        return redirect()->route('milestones.milestone', ['milestone' => $milestone]);
    }
}
