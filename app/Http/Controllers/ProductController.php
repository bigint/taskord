<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductUpdate;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ProductController extends Controller
{
    public function profile($slug): View
    {
        $product = Product::whereSlug($slug)
            ->firstOrFail();
        $type = Route::current()->getName();
        $tasks = $product->tasks()
            ->select('created_at')
            ->get()
            ->groupBy(function ($date) {
                return $date->created_at->format('m');
            });

        $taskCount = [];
        $countArr = [];

        foreach ($tasks as $key => $value) {
            $taskCount[(int) $key] = count($value);
        }

        for ($i = 1; $i <= 12; $i++) {
            if (! empty($taskCount[$i])) {
                $countArr[$i] = $taskCount[$i];
            } else {
                $countArr[$i] = 0;
            }
        }

        $members = $product->members->pluck('id');
        $members->push($product->user->id);

        $doneCount = $product->tasks()
            ->whereDone(true)
            ->whereIn('user_id', $members)
            ->count('id');

        $pendingCount = $product->tasks()
            ->whereDone(false)
            ->whereIn('user_id', $members)
            ->count('id');

        $response = [
            'product' => $product,
            'type' => $type,
            'graph' => $countArr,
            'done_count' => $doneCount,
            'pending_count' => $pendingCount,
            'updates_count' => ProductUpdate::where([
                ['product_id', $product->id],
            ])
                ->count('id'),
        ];

        if (auth()->check() && auth()->user()->id === $product->user->id or auth()->check() && auth()->user()->staff_mode) {
            return view($type, $response);
        }

        if ($product->user->spammy) {
            return abort(404);
        }

        return view($type, $response);
    }

    public function edit($slug): View
    {
        $product = Product::whereSlug($slug)
            ->firstOrFail();

        if (
            auth()->check() && auth()->user()->id === $product->user->id or
            auth()->check() && auth()->user()->staff_mode
        ) {
            return view('product.edit', [
                'product' => $product,
            ]);
        }

        return abort(404);
    }

    public function verify($slug): View
    {
        $product = Product::whereSlug($slug)
            ->firstOrFail();

        if (
            auth()->check() && auth()->user()->id === $product->user->id or
            auth()->check() && auth()->user()->staff_mode
        ) {
            return view('product.verify', [
                'product' => $product,
            ]);
        }

        return abort(404);
    }

    public function newest(): View
    {
        return view('products.products', [
            'type' => 'products.newest',
        ]);
    }

    public function launched(): View
    {
        return view('products.products', [
            'type' => 'products.launched',
        ]);
    }

    public function mention(Request $request)
    {
        if ($request['query'] >= 0) {
            $products = Product::select('slug', 'name', 'avatar')
                ->whereUserId(auth()->id())
                ->orWhereHas('members', function (Builder $query) {
                    $query->whereUserId(auth()->id());
                })
                ->search($request['query'])
                ->take(10)
                ->get();
        } else {
            $products = '';
        }

        return $products;
    }

    public function popover(Product $product): View
    {
        return view('product.popover', [
            'product' => $product,
        ]);
    }
}
