<?php

namespace App\Http\Livewire\Products;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Livewire\Component;

class Products extends Component
{
    public $type;
    public $page;
    public $perPage;
    public $readyToLoad = false;

    public function mount($page, $perPage, $type)
    {
        $this->type = $type;
        $this->page = $page ? $page : 1;
        $this->perPage = $perPage ? $perPage : 1;
    }

    public function loadProducts()
    {
        $this->readyToLoad = true;
    }

    public function getProducts()
    {
        if ($this->type === 'products.newest') {
            return Product::with(['user'])
                ->orderBy('created_at', 'desc')
                ->get()
                ->groupBy(function ($date) {
                    return $date->created_at->format('Y,W');
                });
        } elseif ($this->type === 'products.launched') {
            return Product::with(['user'])
                ->whereLaunched(true)
                ->orderBy('created_at', 'desc')
                ->get()
                ->groupBy(function ($date) {
                    return $date->created_at->format('Y,W');
                });
        }
    }

    public function paginate($items, $options = [])
    {
        $page = $this->page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $this->perPage), $items->count(), $this->perPage, $page, $options);
    }

    public function render(): View
    {
        return view('livewire.products.products', [
            'products' => $this->readyToLoad ? $this->paginate($this->getProducts()) : [],
            'page' => $this->page,
        ]);
    }
}
