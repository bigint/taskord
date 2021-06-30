<?php

namespace App\Http\Livewire\Badges;

use App\Models\ProfileBadge;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Subscribers extends Component
{
    use WithPagination;

    public ProfileBadge $badge;
    public $readyToLoad = false;
    protected $paginationTheme = 'bootstrap';

    public function mount($badge)
    {
        $this->badge = $badge;
    }

    public function loadSubscribers()
    {
        $this->readyToLoad = true;
    }

    public function render(): View
    {
        $subscribers = $this->badge->subscribers()->paginate(10);

        return view('livewire.badges.subscribers', [
            'subscribers' => $this->readyToLoad ? $subscribers : [],
        ]);
    }
}
