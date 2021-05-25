<?php

namespace App\Http\Livewire\Products;

use App\Models\Product;
use Livewire\Component;

class ActiveProducts extends Component
{
    public $ready_to_load = false;

    public function loadActiveProducts()
    {
        $this->ready_to_load = true;
    }

    public function getActiveProducts()
    {
        return Product::whereLaunched(true)
            ->take(10)
            ->get()
            ->sortByDesc(function ($product) {
                return $product->tasks->count('id');
            });
    }

    public function render()
    {
        return view('livewire.products.active-products', [
            'products' => $this->ready_to_load ? $this->getActiveProducts() : [],
        ]);
    }
}
