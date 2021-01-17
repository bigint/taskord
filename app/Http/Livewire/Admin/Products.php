<?php

namespace App\Http\Livewire\Admin;

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

    public function render()
    {
        $products = Product::with('owner')
            ->withCount(['members', 'tasks', 'product_update'])
            ->latest()->paginate(50);

        $count = Product::all()->count('id');

        return view('livewire.admin.products', [
            'products' => $this->readyToLoad ? $products : [],
            'count'    => $this->readyToLoad ? $count : [],
        ]);
    }
}
