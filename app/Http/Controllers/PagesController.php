<?php

namespace App\Http\Controllers;

use App\Models\Deal;

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
    
    public function deals()
    {
        $deals = Deal::all();
        
        return view('pages/deals', [
            'deals' => $deals,
        ]);
    }

    public function open()
    {
        return view('pages/open');
    }
}
