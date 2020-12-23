<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use App\Models\ProductUpdate;
use Livewire\Component;

class Updates extends Component
{
    public Product $product;

    public $listeners = [
        'updateDeleted' => 'render',
    ];

    public function mount($product)
    {
        $this->product = $product;
    }

    public function render()
    {
        $updates = ProductUpdate::cacheFor(60 * 60)
            ->where('product_id', $this->product->id)
            ->latest()
            ->paginate(10);

        return view('livewire.product.updates', [
            'updates' => $updates,
        ]);
    }
}
