<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Tasks extends Component
{
    public $listeners = [
        'refreshTasks' => 'render',
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
        $members->push($this->product->user->id);

        return $this->product->tasks()
            ->with(['user', 'product', 'milestone', 'comments.user', 'oembed'])
            ->whereDone($this->type === 'product.done' ? true : false)
            ->whereIn('user_id', $members)
            ->latest('updated_at')
            ->paginate(10, '*', null, $this->page);
    }

    public function render(): View
    {
        return view('livewire.product.tasks', [
            'tasks' => $this->readyToLoad ? $this->getTasks() : [],
            'page' => $this->page,
        ]);
    }
}
