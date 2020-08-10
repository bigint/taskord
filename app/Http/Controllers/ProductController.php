<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class ProductController extends Controller
{
    public function profile($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $type = Route::current()->getName();

        $response = [
            'product' => $product,
            'type' => $type,
            'done_count' => Task::cacheFor(60 * 60)
                ->where([
                    ['product_id', $product->id],
                    ['done', true],
                    ['user_id', $product->user->id],
                ])
                ->count('id'),
            'pending_count' => Task::cacheFor(60 * 60)
                ->where([
                    ['product_id', $product->id],
                    ['done', false],
                    ['user_id', $product->user->id],
                ])
                ->count('id'),
        ];

        if (Auth::check() && Auth::id() === $product->user->id or Auth::check() && Auth::user()->staffShip) {
            return view($type, $response);
        } elseif ($product->user->isFlagged) {
            return view('errors.404');
        }

        return view($type, $response);
    }

    public function newUpdate($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        if (Auth::user()->staffShip or Auth::id() === $product->user->id) {
            return view('product.new-update', [
                'product' => $product,
            ]);
        } else {
            return redirect()->route('product.done', [
                'slug' => $product->slug,
            ]);
        }
    }

    public function newest()
    {
        $products = Product::cacheFor(60 * 60)
            ->where('launched', true)
            ->orderBy('created_at', 'DESC')
            ->take(10)
            ->get()
            ->sortByDesc(function ($product) {
                return $product->task->count();
            });

        return view('products.newest', [
            'type' => 'products.newest',
            'products' => $products,
        ]);
    }

    public function launched()
    {
        $products = Product::cacheFor(60 * 60)
            ->where('launched', true)
            ->orderBy('created_at', 'DESC')
            ->take(10)
            ->get()
            ->sortByDesc(function ($product) {
                return $product->task->count();
            });

        return view('products.launched', [
            'type' => 'products.launched',
            'products' => $products,
        ]);
    }

    public function new()
    {
        return view('product.new');
    }

    public function edit($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        if (Auth::user()->staffShip or Auth::id() === $product->user_id) {
            return view('product.edit', [
                'product' => $product,
            ]);
        } else {
            return redirect()->route('product.done', [
                'slug' => $product->slug,
            ]);
        }
    }
}
