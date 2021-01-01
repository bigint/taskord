<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductUpdate;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class ProductController extends Controller
{
    public function profile($slug)
    {
        $product = Product::cacheFor(60 * 60)
            ->where('slug', $slug)
            ->firstOrFail();
        $type = Route::current()->getName();
        $tasks = Task::cacheFor(60 * 60)
            ->where('product_id', $product->id)
            ->select('created_at')
            ->get()
            ->groupBy(function ($date) {
                return $date->created_at->format('m');
            });

        $taskmcount = [];
        $countArr = [];

        foreach ($tasks as $key => $value) {
            $taskmcount[(int) $key] = count($value);
        }

        for ($i = 1; $i <= 12; $i++) {
            if (! empty($taskmcount[$i])) {
                $countArr[$i] = $taskmcount[$i];
            } else {
                $countArr[$i] = 0;
            }
        }

        $members = $product->members->pluck('id');
        $members->push($product->owner->id);

        $done_count = Task::cacheFor(60 * 60)
            ->where([
                ['product_id', $product->id],
                ['done', true],
            ])
            ->whereIn('user_id', $members)
            ->count('id');

        $pending_count = Task::cacheFor(60 * 60)
            ->where([
                ['product_id', $product->id],
                ['done', false],
            ])
            ->whereIn('user_id', $members)
            ->count('id');

        $response = [
            'product' => $product,
            'type' => $type,
            'graph' => $countArr,
            'done_count' => $done_count,
            'pending_count' => $pending_count,
            'updates_count' => ProductUpdate::cacheFor(60 * 60)
                ->where([
                    ['product_id', $product->id],
                ])
                ->count('id'),
        ];

        if (Auth::check() && Auth::id() === $product->owner->id or Auth::check() && Auth::user()->staffShip) {
            return view($type, $response);
        } elseif ($product->owner->isFlagged) {
            return view('errors.404');
        }

        return view($type, $response);
    }

    public function newest()
    {
        return view('products.newest', [
            'type' => 'products.newest',
        ]);
    }

    public function launched()
    {
        return view('products.launched', [
            'type' => 'products.launched',
        ]);
    }

    public function mention(Request $request)
    {
        if ($request['query']) {
            $users = Product::cacheFor(60 * 60)
                ->select('slug', 'name', 'avatar')
                ->where('slug', 'LIKE', '%'.$request['query'].'%')
                ->orWhere('name', 'LIKE', '%'.$request['query'].'%')
                ->take(10)
                ->get();
        } else {
            $users = '';
        }

        return $users;
    }

    public function popover($id)
    {
        $product = Product::find($id);

        return view('product.popover', [
            'product' => $product,
        ]);
    }
}
