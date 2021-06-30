<?php

namespace App\Http\Livewire\Badges;

use App\Models\ProfileBadge;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class LoadMore extends Component
{
    public $page;
    public $perPage;
    public $loadMore;
    public $readyToLoad = true;

    public function mount($page, $perPage)
    {
        $this->page = $page + 1;
        $this->perPage = $perPage;
        $this->loadMore = false;
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

    public function render(): View
    {
        if ($this->loadMore) {
            $badges = ProfileBadge::with(['user'])
            ->latest()
            ->get();

            return view('livewire.badges.badges', [
                'badges' => $this->paginate($badges),
            ]);
        }

        return view('livewire.load-more');
    }
}
