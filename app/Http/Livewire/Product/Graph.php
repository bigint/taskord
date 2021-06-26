<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use Carbon\CarbonPeriod;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Graph extends Component
{
    public Product $product;
    public $readyToLoad = false;

    public function mount($product)
    {
        $this->product = $product;
    }

    public function loadGraph()
    {
        $this->readyToLoad = true;
    }

    public function render(): View
    {
        $startDate = carbon('60 days ago')->format('Y-m-d');
        $currentDate = carbon()->format('Y-m-d');
        $period = CarbonPeriod::create($startDate, $currentDate);

        $weekDates = [];
        $tasks = [];
        foreach ($period->toArray() as $date) {
            array_push($weekDates, carbon($date)->format('d M Y'));
            $count = $this->product->tasks()
                ->select('id', 'created_at')
                ->whereDate('created_at', carbon($date))
                ->count();

            array_push($tasks, $count);
        }

        return view('livewire.product.graph', [
            'week_dates' => $this->readyToLoad ? json_encode($weekDates, JSON_NUMERIC_CHECK) : [],
            'tasks' => $this->readyToLoad ? json_encode($tasks, JSON_NUMERIC_CHECK) : [],
            'count' => $this->readyToLoad ? array_sum($tasks) : 0,
        ]);
    }
}
