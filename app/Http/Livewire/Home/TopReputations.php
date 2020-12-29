<?php

namespace App\Http\Livewire\Home;

use Livewire\Component;
use App\Models\User;

class TopReputations extends Component
{
    public $readyToLoad = false;

    public function loadTopReputations()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        $reputations = User::cacheFor(60 * 60)
            ->select('id', 'username', 'firstname', 'lastname', 'avatar', 'reputation', 'isVerified')
            ->where([
                ['isFlagged', false],
                ['id', '!=', 1],
            ])
            ->orderBy('reputation', 'DESC')
            ->take(10)
            ->get();

        return view('livewire.home.top-reputations', [
            'reputations' => $this->readyToLoad ? $reputations : [],
        ]);
    }
}
