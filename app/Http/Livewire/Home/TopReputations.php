<?php

namespace App\Http\Livewire\Home;

use App\Models\User;
use Livewire\Component;

class TopReputations extends Component
{
    public $ready_to_load = false;

    public function loadTopReputations()
    {
        $this->ready_to_load = true;
    }

    public function getTopReputations()
    {
        return User::select('id', 'username', 'firstname', 'lastname', 'avatar', 'reputation', 'status', 'status_emoji', 'is_verified')
            ->where([
                ['spammy', false],
                ['id', '!=', 1],
            ])
            ->orderBy('reputation', 'DESC')
            ->take(10)
            ->get();
    }

    public function render()
    {
        return view('livewire.home.top-reputations', [
            'reputations' => $this->ready_to_load ? $this->getTopReputations() : [],
        ]);
    }
}
