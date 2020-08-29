<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductUpdate;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function profile($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $type = Route::current()->getName();
        $tasks = Task::where('product_id', $product->id)
            ->select('id', 'created_at')
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('m');
            });
        $taskmcount = [];
        $countArr = [];
        
        foreach ($tasks as $key => $value) {
            $taskmcount[(int)$key] = count($value);
        }
        
        for($i = 1; $i <= 12; $i++) {
            if(!empty($taskmcount[$i])) {
                $countArr[$i] = $taskmcount[$i];    
            } else {
                $countArr[$i] = 0;    
            }
        }

        //dd($countArr);

        $response = [
            'product' => $product,
            'type' => $type,
            'graph' => $countArr,
            'done_count' => Task::where([
                ['product_id', $product->id],
                ['done', true],
                ['user_id', $product->user->id],
            ])
                ->count('id'),
            'pending_count' => Task::where([
                ['product_id', $product->id],
                ['done', false],
                ['user_id', $product->user->id],
            ])
                ->count('id'),
            'updates_count' => ProductUpdate::where([
                ['product_id', $product->id],
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
        $products = Product::where('launched', true)
            ->orderBy('created_at', 'DESC')
            ->take(10)
            ->get()
            ->sortByDesc(function ($product) {
                return $product->task->count('id');
            });

        return view('products.newest', [
            'type' => 'products.newest',
            'products' => $products,
        ]);
    }

    public function launched()
    {
        $products = Product::where('launched', true)
            ->orderBy('created_at', 'DESC')
            ->take(10)
            ->get()
            ->sortByDesc(function ($product) {
                return $product->task->count('id');
            });

        return view('products.launched', [
            'type' => 'products.launched',
            'products' => $products,
        ]);
    }
}
