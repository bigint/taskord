<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
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
        return $this->user->ownedProducts()
            ->with(['user', 'members'])
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.user.products', [
            'products' => $this->readyToLoad ? $this->getProducts() : [],
        ]);
    }
}
