<?php

namespace App\Http\Livewire\Home;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class TopReputations extends Component
{
    public $readyToLoad = false;

    public function loadTopReputations()
    {
        $this->readyToLoad = true;
    }

    public function getTopReputations()
    {
        return User::select('id', 'username', 'firstname', 'lastname', 'avatar', 'reputation', 'status', 'status_emoji', 'is_verified')
            ->where([
                ['spammy', false],
                ['is_private', false],
                ['id', '!=', 1],
            ])
            ->orderBy('reputation', 'DESC')
            ->take(10)
            ->get();
    }

    public function render(): View
    {
        return view('livewire.home.top-reputations', [
            'reputations' => $this->readyToLoad ? $this->getTopReputations() : [],
        ]);
    }
}
