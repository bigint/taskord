<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function about()
    {
        return view('pages/about');
    }
    
    public function reputation()
    {
        return view('pages/reputation');
    }
    
    public function terms()
    {
        return view('pages/terms');
    }
    
    public function privacy()
    {
        return view('pages/privacy');
    }
    
    public function security()
    {
        return view('pages/security');
    }
    
    public function open()
    {
        return view('pages/open');
    }
}
