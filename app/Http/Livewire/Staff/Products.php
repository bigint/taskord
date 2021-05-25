<?php

namespace App\Http\Livewire\Staff;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination;

    protected string $paginationTheme = 'bootstrap';

    public bool $ready_to_load = false;

    public function loadProducts()
    {
        $this->ready_to_load = true;
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
            'products' => $this->ready_to_load ? $this->getProducts() : [],
            'count'    => $this->ready_to_load ? Product::count('id') : [],
        ]);
    }
}
