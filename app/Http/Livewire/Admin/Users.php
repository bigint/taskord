<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class Users extends Component
{
    public function render()
    {
        $users = User::latest('last_active')->paginate(50);
        $count = User::all()->count('id');

        return view('livewire.admin.users', [
            'users' => $users,
            'count' => $count,
        ]);
    }
}
