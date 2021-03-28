<?php

namespace App\Http\Livewire\Milestone;

use App\Models\Milestone;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Livewire\Component;

class LoadMore extends Component
{
    public $type;
    public $page;
    public $perPage;
    public $loadMore;
    public $readyToLoad = true;

    public function mount($page, $perPage, $type)
    {
        $this->type = $type;
        $this->page = $page + 1; //increment the page
        $this->perPage = $perPage;
        $this->loadMore = false; //show the button
    }

    public function paginate($items, $options = [])
    {
        $page = $this->page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $this->perPage), $items->count(), $this->perPage, $page, $options);
    }

    public function loadMore()
    {
        $this->loadMore = true;
    }

    public function render()
    {
        if ($this->loadMore) {
            $milestones = Milestone::whereHas('user', function ($q) {
                $q->where([
                    ['isFlagged', false],
                ]);
            })
                ->latest()
                ->get();

            return view('livewire.milestone.milestones', [
                'milestones' => $this->paginate($milestones),
            ]);
        } else {
            return view('livewire.load-more');
        }
    }
}
