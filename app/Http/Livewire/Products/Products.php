<?php

namespace App\Http\Livewire\Products;

use App\Models\Product;
use Carbon\Carbon;
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

    public function paginate($items, $options = [])
    {
        $page = $this->page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $this->perPage), $items->count(), $this->perPage, $page, $options);
    }

    public function render()
    {
        if ($this->type === 'products.newest') {
            $products = Product::cacheFor(60 * 60)
                ->orderBy('created_at', 'desc')
                ->get()
                ->groupBy(function ($date) {
                    return $date->created_at->format('Y,W');
                });
        } elseif ($this->type === 'products.launched') {
            $products = Product::cacheFor(60 * 60)
                ->where('launched', true)
                ->orderBy('created_at', 'desc')
                ->get()
                ->groupBy(function ($date) {
                    return $date->created_at->format('Y,W');
                });
        }

        return view('livewire.products.products', [
            'products' => $this->readyToLoad ? $this->paginate($products) : [],
            'page' => $this->page,
        ]);
    }
}
