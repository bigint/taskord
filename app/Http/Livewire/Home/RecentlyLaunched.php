<?php

namespace App\Http\Livewire\Home;

use App\Models\Product;
use Livewire\Component;

class RecentlyLaunched extends Component
{
    public $readyToLoad = false;

    public function loadRecentlyLaunched()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        $products = Product::cacheFor(60 * 60)
            ->select('id', 'slug', 'name', 'launched', 'avatar', 'user_id')
            ->where('launched', true)
            ->orderBy('created_at', 'DESC')
            ->take(5)
            ->get();

        return view('livewire.home.recently-launched', [
            'products' => $this->readyToLoad ? $products : [],
        ]);
    }
}
