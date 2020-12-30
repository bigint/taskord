<?php

namespace App\Http\Livewire\Home;

use App\Models\Product;
use Carbon\Carbon;
use Livewire\Component;

class LaunchedToday extends Component
{
    public $readyToLoad = false;

    public function loadLaunchedToday()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        $launched_today = Product::cacheFor(60 * 60)
            ->select('id', 'slug', 'name', 'launched', 'description', 'avatar', 'user_id')
            ->where('launched', true)
            ->whereDate('launched_at', Carbon::today())
            ->orderBy('launched_at', 'DESC')
            ->take(6)
            ->get();

        return view('livewire.home.launched-today', [
            'launched_today' => $this->readyToLoad ? $launched_today : [],
        ]);
    }
}
