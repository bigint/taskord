<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Following extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public User $user;
    public $readyToLoad = false;

    public function loadFollowing()
    {
        $this->readyToLoad = true;
    }

    public function mount($user)
    {
        $this->user = $user;
    }

    public function render()
    {
        $followings = $this->user->followings()->paginate(10);

        return view('livewire.user.following', [
            'followings' => $this->readyToLoad ? $followings : [],
        ]);
    }
}
