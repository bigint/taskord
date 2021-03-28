<?php

namespace App\Http\Livewire\Milestone;

use App\Models\Milestone;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EditMilestone extends Component
{
    public Milestone $milestone;
    public $name;
    public $description;

    public function mount($milestone)
    {
        $this->milestone = $milestone;
        $this->name = $milestone->name;
        $this->description = $milestone->description;
    }

    public function updated($field)
    {
        if (Auth::check()) {
            $this->validateOnly($field, [
                'name' => 'required|min:5|max:100',
                'description' => 'required|min:3|max:10000',
            ]);
        } else {
            $this->alert('error', 'Forbidden!');
        }
    }

    public function submit()
    {
        if (Auth::check()) {
            $this->validate([
                'name' => 'required|min:5|max:100',
                'description' => 'required|min:3|max:10000',
            ]);

            if (! auth()->user()->hasVerifiedEmail()) {
                return $this->alert('warning', 'Your email is not verified!');
            }

            if (auth()->user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!');
            }

            $milestone = Milestone::where('id', $this->milestone->id)->firstOrFail();

            if (auth()->user()->staffShip or auth()->user()->id === $milestone->user_id) {
                $milestone->name = $this->name;
                $milestone->description = $this->description;
                $milestone->save();
                auth()->user()->touch();

                loggy(request()->ip(), 'Milestone', auth()->user(), 'Updated a milestone | Milestone ID: '.$milestone->id);
                $this->flash('success', 'Milestone has been edited!');

                return redirect()->route('milestone.milestone', ['id' => $milestone->id]);
            } else {
                $this->alert('error', 'Forbidden!');
            }
        } else {
            $this->alert('error', 'Forbidden!');
        }
    }
}
