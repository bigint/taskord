<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Subscribers extends Component
{
    use WithPagination;

    public Product $product;
    public $readyToLoad = false;
    protected $paginationTheme = 'bootstrap';

    public function loadSubscribers()
    {
        $this->readyToLoad = true;
    }

    public function mount($product)
    {
        $this->product = $product;
    }

    public function render(): View
    {
        $subscribers = $this->product->subscribers()->paginate(10);

        return view('livewire.product.subscribers', [
            'subscribers' => $this->readyToLoad ? $subscribers : [],
        ]);
    }
}
