<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class LoadMore extends Component
{
    public $listeners = [
        'refreshTasks' => 'render',
    ];

    public Product $product;
    public $type;
    public $page;
    public $loadMore;
    public $readyToLoad = true;

    public function mount($product, $type, $page = 1)
    {
        $this->product = $product;
        $this->type = $type;
        $this->page = $page + 1;
        $this->loadMore = false;
    }

    public function loadMore()
    {
        $this->loadMore = true;
    }

    public function render(): View
    {
        if ($this->loadMore) {
            $members = $this->product->members->pluck('id');
            $members->push($this->product->user->id);
            $tasks = $this->product->tasks()
                ->with(['user', 'product', 'milestone', 'comments.user', 'oembed'])
                ->whereDone($this->type === 'product.done' ? true : false)
                ->whereIn('user_id', $members)
                ->orderBy('created_at', 'desc')
                ->orderBy('done_at', 'desc')
                ->paginate(10, '*', null, $this->page);

            return view('livewire.product.tasks', [
                'tasks' => $tasks,
            ]);
        }

        return view('livewire.load-more');
    }
}
