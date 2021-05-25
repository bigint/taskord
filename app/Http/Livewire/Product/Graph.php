<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use Carbon\CarbonPeriod;
use Livewire\Component;

class Graph extends Component
{
    public Product $product;
    public $ready_to_load = false;

    public function mount($product)
    {
        $this->product = $product;
    }

    public function loadGraph()
    {
        $this->ready_to_load = true;
    }

    public function render()
    {
        $start_date = carbon('60 days ago')->format('Y-m-d');
        $current_date = carbon()->format('Y-m-d');
        $period = CarbonPeriod::create($start_date, $current_date);

        $week_dates = [];
        $tasks = [];
        foreach ($period->toArray() as $date) {
            array_push($week_dates, carbon($date)->format('d M Y'));
            $count = $this->product->tasks()
                ->select('id', 'created_at')
                ->whereDate('created_at', carbon($date))
                ->count();

            array_push($tasks, $count);
        }

        return view('livewire.product.graph', [
            'week_dates' => $this->ready_to_load ? json_encode($week_dates, JSON_NUMERIC_CHECK) : [],
            'tasks' => $this->ready_to_load ? json_encode($tasks, JSON_NUMERIC_CHECK) : [],
            'count' => $this->ready_to_load ? array_sum($tasks) : 0,
        ]);
    }
}
