<?php

namespace App\Http\Livewire\Home;

use App\Models\Product;
use Livewire\Component;

class LaunchedToday extends Component
{
    public $ready_to_load = false;

    public function loadLaunchedToday()
    {
        $this->ready_to_load = true;
    }

    public function getLaunchedToday()
    {
        return Product::select('id', 'slug', 'name', 'launched', 'description', 'avatar', 'user_id')
            ->whereLaunched(true)
            ->whereDate('launched_at', carbon('today'))
            ->orderBy('launched_at', 'DESC')
            ->take(6)
            ->get();
    }

    public function render()
    {
        return view('livewire.home.launched-today', [
            'launched_today' => $this->ready_to_load ? $this->getLaunchedToday() : [],
        ]);
    }
}
