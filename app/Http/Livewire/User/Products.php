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
    public $ready_to_load = false;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function loadProducts()
    {
        $this->ready_to_load = true;
    }

    public function getProducts()
    {
        return $this->user->ownedProducts()
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.user.products', [
            'products' => $this->ready_to_load ? $this->getProducts() : [],
        ]);
    }
}
