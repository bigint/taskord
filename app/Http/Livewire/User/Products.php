<?php

namespace App\Http\Livewire\User;

use App\Models\Product;
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

    public function render()
    {
        $products = Product::cacheFor(60 * 60)
            ->where('user_id', $this->user->id)
            ->paginate(10);

        return view('livewire.user.products', [
            'products' => $this->readyToLoad ? $products : [],
        ]);
    }
}
