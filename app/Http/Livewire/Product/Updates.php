<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Updates extends Component
{
    public Product $product;

    public $listeners = [
        'refreshProduct' => 'render',
    ];

    public function mount($product)
    {
        $this->product = $product;
    }

    public function render(): View
    {
        $updates = $this->product->productUpdates()
            ->with(['user'])
            ->latest()
            ->paginate(10);

        return view('livewire.product.updates', [
            'updates' => $updates,
        ]);
    }
}
