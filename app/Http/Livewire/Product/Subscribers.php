<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use App\Models\Product;

class Subscribers extends Component
{
    public Product $product;

    public function mount($product)
    {
        $this->product = $product;
    }
}
