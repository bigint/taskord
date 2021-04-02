<?php

namespace App\Http\Livewire\Milestone;

use App\Models\Milestone;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Livewire\Component;

class Milestones extends Component
{
    public $type;
    public $page;
    public $perPage;
    public $readyToLoad = false;

    public function mount($page, $perPage, $type)
    {
        $this->type = $type;
        $this->page = $page ? $page : 1;
        $this->perPage = $perPage ? $perPage : 1;
    }

    public function loadMilestones()
    {
        $this->readyToLoad = true;
    }

    public function getMilestones()
    {
        if ($this->type === 'milestones.opened') {
            return Milestone::where('status', true)
                ->whereHas('user', function ($q) {
                    $q->where([
                        ['isFlagged', false],
                    ]);
                })
                ->latest()
                ->get();
        } elseif ($this->type === 'milestones.closed') {
            return Milestone::where('status', false)
                ->whereHas('user', function ($q) {
                    $q->where([
                        ['isFlagged', false],
                    ]);
                })
                ->latest()
                ->get();
        }
    }

    public function paginate($items, $options = [])
    {
        $page = $this->page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $this->perPage), $items->count(), $this->perPage, $page, $options);
    }

    public function render()
    {
        return view('livewire.milestone.milestones', [
            'milestones' => $this->readyToLoad ? $this->paginate($this->getMilestones()) : [],
            'page' => $this->page,
        ]);
    }
}
