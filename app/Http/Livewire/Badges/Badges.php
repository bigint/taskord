<?php

namespace App\Http\Livewire\Badges;

use App\Models\ProfileBadge;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Badges extends Component
{
    use WithPagination;

    public $query;
    public $readyToLoad = false;
    protected $paginationTheme = 'bootstrap';

    public function loadBadges()
    {
        $this->readyToLoad = true;
    }

    public function getBadges()
    {
        return ProfileBadge::with(['user'])
            ->search($this->query)
            ->latest()
            ->paginate(20);
    }

    public function render(): View
    {
        return view('livewire.badges.badges', [
            'badges' => $this->readyToLoad ? $this->getBadges() : [],
        ]);
    }
}
