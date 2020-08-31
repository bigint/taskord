<?php

namespace App\Http\Livewire\Product;

use App\Models\ProductUpdate;
use Livewire\Component;

class Updates extends Component
{
    public $product;
    
    public $listeners = [
        'updateDeleted' => 'render',
    ];

    public function mount($product)
    {
        $this->product = $product;
    }

    public function render()
    {
        $updates = ProductUpdate::where('product_id', $this->product->id)
            ->latest()
            ->paginate(20);

        return view('livewire.product.updates', [
            'updates' => $updates,
        ]);
    }
}
