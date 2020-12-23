<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Task;
use App\Models\User;

class FeedController extends Controller
{
    public function user($username, $page = 1)
    {
        $user = User::cacheFor(60 * 60)
            ->where('username', $username)
            ->firstOrFail();
        $tasks = Task::cacheFor(60 * 60)
            ->where('user_id', $user->id)
            ->latest()
            ->offset($page - 1)
            ->limit(50)
            ->get();

        $content = view('feed.user', [
            'user' => $user,
            'tasks' => $tasks,
        ]);

        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }

    public function product($slug, $page = 1)
    {
        $product = Product::cacheFor(60 * 60)
            ->where('slug', $slug)
            ->firstOrFail();
        $tasks = Task::cacheFor(60 * 60)
            ->where('product_id', $product->id)
            ->latest()
            ->offset($page - 1)
            ->limit(50)
            ->get();

        $content = view('feed.product', [
            'product' => $product,
            'tasks' => $tasks,
        ]);

        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }
}
