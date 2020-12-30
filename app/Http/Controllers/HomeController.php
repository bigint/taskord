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
        return view('home/home');
    }
}
