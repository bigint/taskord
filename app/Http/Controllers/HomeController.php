<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __construct()
    {
        //$this->middleware('verified');
    }

    public function index()
    {
        $launched_today = Product::cacheFor(60 * 60)
            ->select('id', 'slug', 'name', 'launched', 'description', 'avatar', 'user_id')
            ->where('launched', true)
            ->whereDate('launched_at', Carbon::today())
            ->orderBy('launched_at', 'DESC')
            ->take(6)
            ->get();

        return view('home/home', [
            'launched_today' => $launched_today,
        ]);
    }
}
