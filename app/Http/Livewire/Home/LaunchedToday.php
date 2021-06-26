<?php

namespace App\Http\Livewire\Home;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class LaunchedToday extends Component
{
    public $readyToLoad = false;

    public function loadLaunchedToday()
    {
        $this->readyToLoad = true;
    }

    public function getLaunchedToday()
    {
        return Product::select('id', 'slug', 'name', 'launched', 'description', 'avatar', 'user_id')
            ->with(['user', 'members'])
            ->whereLaunched(true)
            ->whereDate('launched_at', carbon('today'))
            ->orderBy('launched_at', 'DESC')
            ->take(6)
            ->get();
    }

    public function render(): View
    {
        return view('livewire.home.launched-today', [
            'launched_today' => $this->readyToLoad ? $this->getLaunchedToday() : [],
        ]);
    }
}
