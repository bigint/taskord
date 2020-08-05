<?php

namespace App\Http\Livewire\User;

use App\Product;
use Livewire\Component;

class Products extends Component
{
    public $user_id;

    public function mount($user)
    {
        $this->user_id = $user->id;
    }

    public function render()
    {
        $products = Product::cacheFor(60 * 60)
            ->where('user_id', $this->user_id)
            ->paginate(20);

        return view('livewire.user.products', [
            'products' => $products,
        ]);
    }
}
