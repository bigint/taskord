<?php

namespace App\Http\Livewire\Staff;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $ready_to_load = false;

    public function loadUsers()
    {
        $this->ready_to_load = true;
    }

    public function getUsers()
    {
        return User::latest('last_active')->paginate(50);
    }

    public function render()
    {
        return view('livewire.staff.users', [
            'users' => $this->ready_to_load ? $this->getUsers() : [],
            'count' => $this->ready_to_load ? User::count('id') : [],
        ]);
    }
}
