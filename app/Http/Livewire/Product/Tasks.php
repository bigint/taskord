<?php

namespace App\Http\Livewire\Product;

use App\Task;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Livewire\Component;

class Tasks extends Component
{
    public $listeners = [
        'taskAdded' => 'render',
        'taskDeleted' => 'render',
        'taskChecked' => 'render',
    ];

    public $product;
    public $type;
    public $page;
    public $perPage;

    public function mount($product, $type, $page, $perPage)
    {
        $this->product = $product;
        $this->type = $type;
        $this->page = $page ? $page : 1;
        $this->perPage = $perPage ? $perPage : 1;
    }

    public function paginate($items, $options = [])
    {
        $page = $this->page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $this->perPage), $items->count(), $this->perPage, $page, $options);
    }

    public function render()
    {
        $tasks = Task::cacheFor(60 * 60)
            ->where([
                ['product_id', $this->product->id],
                ['user_id', $this->product->user->id],
                ['done', $this->type === 'product.done' ? true : false],
            ])
            ->orderBy('created_at', 'desc')
            ->orderBy('done_at', 'desc')
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->done_at)->format('d-M-y');
            });

        return view('livewire.product.tasks', [
            'tasks' => $this->paginate($tasks),
            'page' => $this->page,
        ]);
    }
}
