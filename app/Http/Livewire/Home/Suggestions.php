<?php

namespace App\Http\Livewire\Home;

use App\Models\User;
use Livewire\Component;

class Suggestions extends Component
{
    protected $listeners = ['userFollowed' => 'render'];
    public $readyToLoad = false;
    public User $user;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function loadSuggestions()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        $users = User::cacheFor(60 * 60)
            ->select('id', 'username', 'firstname', 'lastname', 'reputation', 'avatar', 'isVerified', 'last_active')
            ->whereNotIn('id', $this->user->followings->pluck('id'))
            ->where([
                ['isFlagged', false],
                ['id', '!=', $this->user->id],
            ])
            ->latest('last_active')
            ->orderBy('reputation', 'DESC')
            ->take(5)
            ->get();

        return view('livewire.home.suggestions', [
            'users' => $this->readyToLoad ? $users : [],
        ]);
    }
}
