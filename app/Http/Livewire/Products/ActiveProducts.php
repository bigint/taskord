<?php

namespace App\Http\Livewire\Products;

use App\Models\Product;
use Livewire\Component;

class ActiveProducts extends Component
{
    public $readyToLoad = false;

    public function loadActiveProducts()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        $products = Product::cacheFor(60 * 60)
            ->where('launched', true)
            ->take(10)
            ->get()
            ->sortByDesc(function ($product) {
                return $product->tasks->count('id');
            });

        return view('livewire.products.active-products', [
            'products' => $this->readyToLoad ? $products : [],
        ]);
    }
}
