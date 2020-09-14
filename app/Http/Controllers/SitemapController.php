<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;

class SitemapController extends Controller
{
    public function users()
    {
        $users = User::all();

        return view('seo.sitemap_users', [
            'users' => $users,
        ]);
    }
    
    public function products()
    {
        $products = Product::all();

        return view('seo.sitemap_products', [
            'products' => $products,
        ]);
    }
}
