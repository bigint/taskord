<?php

namespace App\Http\Livewire\Milestone;

use App\Models\Milestone;
use Livewire\Component;

class Progress extends Component
{
    public $listeners = [
        'refreshTasks' => 'render',
    ];

    public Milestone $milestone;
    public $ready_to_load = false;

    public function mount($milestone)
    {
        $this->milestone = $milestone;
    }

    public function loadProgress()
    {
        $this->ready_to_load = true;
    }

    public function render()
    {
        $completed = $this->milestone->tasks()->whereDone(true)->count();
        $pending = $this->milestone->tasks()->whereDone(false)->count();
        $total = $this->milestone->tasks()->count();
        if ($total != 0) {
            $percent = number_format($completed / $total * 100, 0);
        } else {
            $percent = 0;
        }

        return view('livewire.milestone.progress', [
            'completed' => $this->ready_to_load ? $completed : 0,
            'pending' => $this->ready_to_load ? $pending : 0,
            'percent' => $this->ready_to_load ? $percent : 0,
        ]);
    }
}
