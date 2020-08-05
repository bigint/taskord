<?php

namespace App\Http\Livewire\Products;

use App\Product;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Livewire\Component;

class LoadMore extends Component
{
    public $type;
    public $page;
    public $perPage;
    public $loadMore;

    public function mount($page, $perPage, $type)
    {
        $this->type = $type;
        $this->page = $page + 1; //increment the page
        $this->perPage = $perPage;
        $this->loadMore = false; //show the button
    }

    public function paginate($items, $options = [])
    {
        $page = $this->page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $this->perPage), $items->count(), $this->perPage, $page, $options);
    }

    public function loadMore()
    {
        $this->loadMore = true;
    }

    public function render()
    {
        if ($this->loadMore) {
            if ($this->type === 'products.newest') {
                $products = Product::cacheFor(60 * 60)
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->groupBy(function ($date) {
                        return Carbon::parse($date->created_at)->format('Y,W');
                    });
            } elseif ($this->type === 'products.launched') {
                $products = Product::cacheFor(60 * 60)
                    ->where('launched', true)
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->groupBy(function ($date) {
                        return Carbon::parse($date->created_at)->format('Y,W');
                    });
            }

            return view('livewire.products.products', [
                'products' => $this->paginate($products),
            ]);
        } else {
            return view('livewire.load-more');
        }
    }
}
