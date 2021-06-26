<?php

namespace App\Http\Livewire\Staff;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination;

    public bool $readyToLoad = false;
    protected string $paginationTheme = 'bootstrap';

    public function loadProducts()
    {
        $this->readyToLoad = true;
    }

    public function getProducts()
    {
        return Product::with('user')
            ->withCount(['members', 'tasks', 'productUpdates'])
            ->latest()
            ->paginate(50);
    }

    public function render(): View
    {
        return view('livewire.staff.products', [
            'products' => $this->readyToLoad ? $this->getProducts() : [],
            'count' => $this->readyToLoad ? Product::count('id') : [],
        ]);
    }
}
