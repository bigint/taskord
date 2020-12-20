<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Question;
use App\Models\User;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('verified');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $launched_today = Product::cacheFor(60 * 60)
            ->where('launched', true)
            ->whereDate('launched_at', Carbon::today())
            ->orderBy('launched_at', 'DESC')
            ->take(6)
            ->get();
        $recent_questions = Question::cacheFor(60 * 60)
            ->select('id', 'title', 'body', 'patronOnly', 'created_at', 'user_id')
            ->orderBy('created_at', 'DESC')
            ->take(5)
            ->get();
        $recent_users = User::cacheFor(60 * 60)
            ->select('username', 'firstname', 'lastname', 'avatar', 'bio', 'isVerified', 'created_at')
            ->where([
                ['created_at', '>=', Carbon::now()->subdays(7)],
                ['isFlagged', false],
            ])
            ->orderBy('created_at', 'DESC');
        $recently_joined = $recent_users->take(5)
            ->get();
        $recently_joined_count = $recent_users->count('id');
        $products = Product::cacheFor(60 * 60)
            ->select('id', 'slug', 'name', 'launched', 'avatar', 'user_id')
            ->where('launched', true)
            ->orderBy('created_at', 'DESC')
            ->take(5)
            ->get();
        $reputations = User::cacheFor(60 * 60)
            ->select('id', 'username', 'firstname', 'lastname', 'avatar', 'reputation', 'isVerified')
            ->where([
                ['isFlagged', false],
                ['id', '!=', 1],
            ])
            ->orderBy('reputation', 'DESC')
            ->take(10)
            ->get();

        return view('home/home', [
            'recent_questions' => $recent_questions,
            'launched_today' => $launched_today,
            'recently_joined' => $recently_joined,
            'recently_joined_count' => $recently_joined_count,
            'products' => $products,
            'reputations' => $reputations,
        ]);
    }
}
