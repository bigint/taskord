<?php

namespace App\Http\Livewire\Product;

use App\Models\Task;
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

    public function mount($product, $type, $page)
    {
        $this->product = $product;
        $this->type = $type;
        $this->page = $page ? $page : 1;
    }

    public function render()
    {
        $members = $this->product->members->pluck('id');
        $members->push($this->product->owner->id);
        $tasks = Task::cacheFor(60 * 60)
            ->select('id', 'task', 'done', 'created_at', 'done_at', 'user_id', 'product_id', 'source', 'images', 'type')
            ->where([
                ['product_id', $this->product->id],
                ['done', $this->type === 'product.done' ? true : false],
            ])
            ->whereIn('user_id', $members)
            ->orderBy('created_at', 'desc')
            ->orderBy('done_at', 'desc')
            ->paginate(20, null, null, $this->page);

        return view('livewire.product.tasks', [
            'tasks' =>$tasks,
            'page' => $this->page,
        ]);
    }
}
