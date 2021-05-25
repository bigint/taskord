<?php

namespace App\Http\Livewire\Staff;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination;

    protected string $paginationTheme = 'bootstrap';

    public bool $readyToLoad = false;

    public function loadProducts()
    {
        $this->readyToLoad = true;
    }

    public function getProducts()
    {
        return Product::with('owner')
            ->withCount(['members', 'tasks', 'product_updates'])
            ->latest()
            ->paginate(50);
    }

    public function render()
    {
        return view('livewire.staff.products', [
            'products' => $this->readyToLoad ? $this->getProducts() : [],
            'count'    => $this->readyToLoad ? Product::count('id') : [],
        ]);
    }
}
