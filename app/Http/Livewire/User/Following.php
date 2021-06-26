<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Following extends Component
{
    use WithPagination;

    public User $user;
    public $readyToLoad = false;
    protected $paginationTheme = 'bootstrap';

    public function loadFollowing()
    {
        $this->readyToLoad = true;
    }

    public function getFollowing()
    {
        return $this->user->followings()->paginate(10);
    }

    public function mount($user)
    {
        $this->user = $user;
    }

    public function render(): View
    {
        return view('livewire.user.following', [
            'followings' => $this->readyToLoad ? $this->getFollowing() : [],
        ]);
    }
}
