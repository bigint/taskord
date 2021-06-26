<?php

namespace App\Http\Livewire\Milestone;

use App\Models\Milestone;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Progress extends Component
{
    public $listeners = [
        'refreshTasks' => 'render',
    ];

    public Milestone $milestone;
    public $readyToLoad = false;

    public function mount($milestone)
    {
        $this->milestone = $milestone;
    }

    public function loadProgress()
    {
        $this->readyToLoad = true;
    }

    public function render(): View
    {
        $completed = $this->milestone->tasks()->whereDone(true)->count();
        $pending = $this->milestone->tasks()->whereDone(false)->count();
        $total = $this->milestone->tasks()->count();
        if ($total !== 0) {
            $percent = number_format($completed / $total * 100, 0);
        } else {
            $percent = 0;
        }

        return view('livewire.milestone.progress', [
            'completed' => $this->readyToLoad ? $completed : 0,
            'pending' => $this->readyToLoad ? $pending : 0,
            'percent' => $this->readyToLoad ? $percent : 0,
        ]);
    }
}
