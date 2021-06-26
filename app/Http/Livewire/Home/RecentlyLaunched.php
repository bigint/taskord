<?php

namespace App\Http\Livewire\Home;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class RecentlyLaunched extends Component
{
    public $readyToLoad = false;

    public function loadRecentlyLaunched()
    {
        $this->readyToLoad = true;
    }

    public function getRecentlyLaunched()
    {
        return Product::select('id', 'slug', 'name', 'launched', 'avatar', 'user_id')
            ->with(['user', 'members'])
            ->whereLaunched(true)
            ->orderBy('created_at', 'DESC')
            ->take(5)
            ->get();
    }

    public function render(): View
    {
        return view('livewire.home.recently-launched', [
            'products' => $this->readyToLoad ? $this->getRecentlyLaunched() : [],
        ]);
    }
}
