<?php

namespace App\Http\Livewire\Products;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ActiveProducts extends Component
{
    public $readyToLoad = false;

    public function loadActiveProducts()
    {
        $this->readyToLoad = true;
    }

    public function getActiveProducts()
    {
        return Product::with(['user', 'members', 'tasks'])
            ->whereLaunched(true)
            ->take(10)
            ->get()
            ->sortByDesc(function ($product) {
                return $product->tasks->count('id');
            });
    }

    public function render(): View
    {
        return view('livewire.products.active-products', [
            'products' => $this->readyToLoad ? $this->getActiveProducts() : [],
        ]);
    }
}
