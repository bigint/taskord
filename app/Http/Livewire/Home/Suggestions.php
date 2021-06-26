<?php

namespace App\Http\Livewire\Home;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Suggestions extends Component
{
    public $readyToLoad = false;
    public $showText;
    public User $user;
    protected $listeners = [
        'refreshSuggestions' => 'render',
    ];

    public function mount($user, $showText = true)
    {
        $this->user = $user;
        $this->showText = $showText;
    }

    public function loadSuggestions()
    {
        $this->readyToLoad = true;
    }

    public function getSuggestions()
    {
        return User::select('id', 'username', 'firstname', 'lastname', 'reputation', 'avatar', 'is_verified', 'status', 'status_emoji', 'last_active')
            ->whereNotIn('id', $this->user->followings->pluck('id'))
            ->where([
                ['spammy', false],
                ['is_private', false],
                ['id', '!=', $this->user->id],
            ])
            ->latest('last_active')
            ->orderBy('reputation', 'DESC')
            ->take(5)
            ->get()
            ->shuffle();
    }

    public function render(): View
    {
        return view('livewire.home.suggestions', [
            'users' => $this->readyToLoad ? $this->getSuggestions() : [],
        ]);
    }
}
