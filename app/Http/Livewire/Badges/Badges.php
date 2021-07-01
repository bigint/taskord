<?php

namespace App\Http\Livewire\Badges;

use App\Models\ProfileBadge;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class Badges extends Component
{
    public $query;
    public $page;
    public $perPage;
    public $readyToLoad = false;

    public function mount($page, $perPage)
    {
        $this->page = $page ? $page : 1;
        $this->perPage = $perPage ? $perPage : 1;
    }

    public function loadBadges()
    {
        $this->readyToLoad = true;
    }

    public function getBadges()
    {
        return ProfileBadge::with(['user'])
            ->search($this->query)
            ->latest()
            ->get();
    }

    public function paginate($items, $options = [])
    {
        $page = $this->page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $this->perPage), $items->count(), $this->perPage, $page, $options);
    }

    public function render(): View
    {
        return view('livewire.badges.badges', [
            'badges' => $this->readyToLoad ? $this->paginate($this->getBadges()) : [],
            'page' => $this->page,
        ]);
    }
}
