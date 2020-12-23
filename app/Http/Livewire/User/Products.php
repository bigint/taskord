<?php

namespace App\Http\Livewire\User;

use App\Models\Product;
use Livewire\Component;
use App\Models\User;

class Products extends Component
{
    public User $user;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function render()
    {
        $products = Product::cacheFor(60 * 60)
            ->where('user_id', $this->user->id)
            ->paginate(10);

        return view('livewire.user.products', [
            'products' => $products,
        ]);
    }
}
