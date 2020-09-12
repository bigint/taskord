<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AddMember extends Component
{
    public $product;
    public $username;
    
    public function mount($product)
    {
        $this->product = $product;
    }
    
    public function submit()
    {
        if (Auth::check()) {
            $user = User::where('username', $this->username)->first();
            if ($user === null) {
               return session()->flash('team-error', 'User does not exists');
            }
            if (Auth::user()->username === $this->username) {
                return session()->flash('team-error', 'You can\'t add yourself to the team!');
            }
        }
    }
    
    public function render()
    {
        return view('livewire.product.add-member');
    }
}
