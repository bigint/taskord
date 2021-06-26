<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Milestones extends Component
{
    use WithPagination;

    public User $user;
    public $readyToLoad = false;
    protected $paginationTheme = 'bootstrap';

    public function mount($user)
    {
        $this->user = $user;
    }

    public function loadMilestones()
    {
        $this->readyToLoad = true;
    }

    public function getMilestones()
    {
        return $this->user->milestones()
            ->latest()
            ->paginate(10);
    }

    public function render(): View
    {
        return view('livewire.user.milestones', [
            'milestones' => $this->readyToLoad ? $this->getMilestones() : [],
        ]);
    }
}
