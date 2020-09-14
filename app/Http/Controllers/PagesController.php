<?php

namespace App\Http\Controllers;

use App\Models\Deal;

class PagesController extends Controller
{
    public function deals()
    {
        $deals = Deal::all();

        return view('pages.deals', [
            'deals' => $deals,
        ]);
    }

    public function open()
    {
        return view('pages.open');
    }
}
