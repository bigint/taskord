<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Milestones extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public User $user;
    public $ready_to_load = false;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function loadMilestones()
    {
        $this->ready_to_load = true;
    }

    public function getMilestones()
    {
        return $this->user->milestones()
            ->latest()
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.user.milestones', [
            'milestones' => $this->ready_to_load ? $this->getMilestones() : [],
        ]);
    }
}
