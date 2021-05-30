<?php

namespace App\Http\Livewire\Staff;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public $readyToLoad = false;
    protected $paginationTheme = 'bootstrap';

    public function loadUsers()
    {
        $this->readyToLoad = true;
    }

    public function getUsers()
    {
        return User::latest('last_active')->paginate(50);
    }

    public function render()
    {
        return view('livewire.staff.users', [
            'users' => $this->readyToLoad ? $this->getUsers() : [],
            'count' => $this->readyToLoad ? User::count('id') : [],
        ]);
    }
}
