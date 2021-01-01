<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Subscribers extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
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
        $subscribers = $this->product->subscribers()->paginate(10);

        return view('livewire.product.subscribers', [
            'subscribers' => $this->readyToLoad ? $subscribers : [],
        ]);
    }
}
