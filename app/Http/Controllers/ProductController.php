<?php

namespace App\Http\Controllers;

use App\Product;
use App\Task;
use Auth;

class ProductController extends Controller
{
    public function done($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        return view('product.done', [
            'product' => $product,
            'type' => 'product.done',
            'done_count' => Task::where([['product_id', $product->id], ['done', true], ['user_id', $product->user->id]])->count(),
            'pending_count' => Task::where([['product_id', $product->id], ['done', false], ['user_id', $product->user->id]])->count(),
        ]);
    }

    public function pending($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        return view('product.pending', [
            'product' => $product,
            'type' => 'product.pending',
            'done_count' => Task::where([['product_id', $product->id], ['done', true], ['user_id', $product->user->id]])->count(),
            'pending_count' => Task::where([['product_id', $product->id], ['done', false], ['user_id', $product->user->id]])->count(),
        ]);
    }
    
    public function updates($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        return view('product.updates', [
            'product' => $product,
            'type' => 'product.pending',
            'done_count' => Task::where([['product_id', $product->id], ['done', true], ['user_id', $product->user->id]])->count(),
            'pending_count' => Task::where([['product_id', $product->id], ['done', false], ['user_id', $product->user->id]])->count(),
        ]);
    }
    
    public function newUpdate($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        
        return view('product.new-update', [
            'product' => $product,
        ]);
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
