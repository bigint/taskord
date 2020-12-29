<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Question;
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
            ->select('id', 'slug', 'name', 'launched', 'description', 'avatar', 'user_id')
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

        return view('home/home', [
            'recent_questions' => $recent_questions,
            'launched_today' => $launched_today,
        ]);
    }
}
