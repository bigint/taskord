<?php

namespace App\Http\Livewire\Milestone;

use App\Models\Milestone;
use Livewire\Component;

class EditMilestone extends Component
{
    public Milestone $milestone;
    public $name;
    public $description;
    public $start_date;
    public $end_date;

    protected $rules = [
        'name' => ['required', 'min:5', 'max:100'],
        'description' => ['required', 'min:3', 'max:10000'],
    ];

    public function mount($milestone)
    {
        $this->milestone = $milestone;
        $this->name = $milestone->name;
        $this->description = $milestone->description;
        $this->start_date = $milestone->start_date ? carbon($milestone->start_date)->format('Y-m-d') : null;
        $this->end_date = $milestone->end_date ? carbon($milestone->end_date)->format('Y-m-d') : null;
    }

    public function updated($field)
    {
        if (auth()->check()) {
            $this->validateOnly($field);
        } else {
            $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Forbidden!',
            ]);
        }
    }

    public function submit()
    {
        if (auth()->check()) {
            $this->validate();

            if (! auth()->user()->hasVerifiedEmail()) {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'Your email is not verified!',
                ]);
            }

            if (auth()->user()->isFlagged) {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'Your account is flagged!',
                ]);
            }

            $milestone = Milestone::where('id', $this->milestone->id)->firstOrFail();

            if (auth()->user()->staffShip or auth()->user()->id === $milestone->user_id) {
                $milestone->name = $this->name;
                $milestone->description = $this->description;
                $milestone->start_date = $this->start_date ? $this->start_date : null;
                $milestone->end_date = $this->start_date ? $this->end_date : null;
                $milestone->save();
                auth()->user()->touch();

                loggy(request(), 'Milestone', auth()->user(), 'Updated a milestone | Milestone ID: '.$milestone->id);

                return redirect()->route('milestones.milestone', ['milestone' => $milestone]);
            } else {
                $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'Forbidden!',
                ]);
            }
        } else {
            $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Forbidden!',
            ]);
        }
    }
}
