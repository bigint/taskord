<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Question;
use App\Models\User;

class SitemapController extends Controller
{
    public function users()
    {
        $users = User::all('username');

        return view('seo.sitemap_users', [
            'users' => $users,
        ]);
    }

    public function products()
    {
        $products = Product::all('slug');

        return view('seo.sitemap_products', [
            'products' => $products,
        ]);
    }

    public function questions()
    {
        $questions = Question::all('id');

        return view('seo.sitemap_questions', [
            'questions' => $questions,
        ]);
    }
}
