<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use Livewire\Component;

class Subscribers extends Component
{
    public Product $product;

    public function mount($product)
    {
        $this->product = $product;
    }
}
