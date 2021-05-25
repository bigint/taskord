<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use Livewire\Component;

class Tasks extends Component
{
    public $listeners = [
        'refreshTasks' => 'render',
    ];

    public Product $product;
    public $type;
    public $page;
    public $ready_to_load = false;

    public function mount($product, $type, $page)
    {
        $this->product = $product;
        $this->type = $type;
        $this->page = $page ? $page : 1;
    }

    public function loadTasks()
    {
        $this->ready_to_load = true;
    }

    public function getTasks()
    {
        $members = $this->product->members->pluck('id');
        $members->push($this->product->owner->id);

        return $this->product->tasks()
            ->whereDone($this->type === 'product.done' ? true : false)
            ->whereIn('user_id', $members)
            ->latest('updated_at')
            ->paginate(10, '*', null, $this->page);
    }

    public function render()
    {
        return view('livewire.product.tasks', [
            'tasks' => $this->ready_to_load ? $this->getTasks() : [],
            'page' => $this->page,
        ]);
    }
}
