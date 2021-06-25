<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Models\User;

class SidebarProducts extends Component
{
    public User $user;
    public $readyToLoad = false;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function loadProducts()
    {
        $this->readyToLoad = true;
    }

    public function getProducts()
    {
        return $this->user
            ->ownedProducts
            ->merge($this->user->products);
    }

    public function render()
    {
        return view('livewire.user.sidebar-products', [
            'products' => $this->readyToLoad ? $this->getProducts() : [],
        ]);
    }
}
