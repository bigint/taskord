<?php

namespace App\Http\Livewire\Home;

use App\Models\User;
use Livewire\Component;

class Suggestions extends Component
{
    protected $listeners = ['userFollowed' => 'render'];
    public $readyToLoad = false;
    public $showText;
    public User $user;

    public function mount($user, $showText = true)
    {
        $this->user = $user;
        $this->showText = $showText;
    }

    public function loadSuggestions()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        $users = User::select('id', 'username', 'firstname', 'lastname', 'reputation', 'avatar', 'isVerified', 'last_active')
            ->whereNotIn('id', $this->user->followings->pluck('id'))
            ->where([
                ['isFlagged', false],
                ['id', '!=', $this->user->id],
            ])
            ->latest('last_active')
            ->orderBy('reputation', 'DESC')
            ->take(5)
            ->get()
            ->shuffle();

        return view('livewire.home.suggestions', [
            'users' => $this->readyToLoad ? $users : [],
        ]);
    }
}
