<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use App\Models\Task;
use Livewire\Component;

class Tasks extends Component
{
    public $listeners = [
        'taskAdded' => 'render',
        'taskDeleted' => 'render',
        'taskChecked' => 'render',
    ];

    public Product $product;
    public $type;
    public $page;
    public $readyToLoad = false;

    public function mount($product, $type, $page)
    {
        $this->product = $product;
        $this->type = $type;
        $this->page = $page ? $page : 1;
    }

    public function loadTasks()
    {
        $this->readyToLoad = true;
    }

    public function getTasks()
    {
        $members = $this->product->members->pluck('id');
        $members->push($this->product->owner->id);

        return Task::where([
            ['product_id', $this->product->id],
            ['done', $this->type === 'product.done' ? true : false],
        ])
            ->whereIn('user_id', $members)
            ->orderBy('created_at', 'desc')
            ->orderBy('done_at', 'desc')
            ->paginate(10, '*', null, $this->page);
    }

    public function render()
    {
        return view('livewire.product.tasks', [
            'tasks' => $this->readyToLoad ? $this->getTasks() : [],
            'page' => $this->page,
        ]);
    }
}
