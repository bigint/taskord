<?php

namespace App\Http\Livewire\User;

use App\Models\ProfileBadge;
use App\Models\User;
use Illuminate\View\View;
use Livewire\Component;

class Badges extends Component
{
    public $readyToLoad = false;
    public User $user;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function loadBadges()
    {
        $this->readyToLoad = true;
    }

    public function getBadges()
    {
        return $this->user
            ->subscriptions(ProfileBadge::class)
            ->get();
    }

    public function render(): View
    {
        return view('livewire.user.badges', [
            'badges' => $this->readyToLoad ? $this->getBadges() : [],
        ]);
    }
}
