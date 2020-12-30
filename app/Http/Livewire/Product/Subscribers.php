<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use Livewire\Component;

class Subscribers extends Component
{
    public Product $product;
    public $readyToLoad = false;

    public function loadSubscribers()
    {
        $this->readyToLoad = true;
    }

    public function mount($product)
    {
        $this->product = $product;
    }

    public function render()
    {
        $subscribers = $this->product->subscribers;

        return view('livewire.product.subscribers', [
            'subscribers' => $this->readyToLoad ? $subscribers : [],
        ]);
    }
}
