<?php

namespace App\Http\Livewire\Home;

use App\Models\Product;
use Livewire\Component;

class RecentlyLaunched extends Component
{
    public $ready_to_load = false;

    public function loadRecentlyLaunched()
    {
        $this->ready_to_load = true;
    }

    public function getRecentlyLaunched()
    {
        return Product::select('id', 'slug', 'name', 'launched', 'avatar', 'user_id')
            ->whereLaunched(true)
            ->orderBy('created_at', 'DESC')
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.home.recently-launched', [
            'products' => $this->ready_to_load ? $this->getRecentlyLaunched() : [],
        ]);
    }
}
