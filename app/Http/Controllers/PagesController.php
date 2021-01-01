<?php

namespace App\Http\Controllers;

use App\Models\Deal;

class PagesController extends Controller
{
    public function deals()
    {
        $deals = Deal::cacheFor(60 * 60)->get();

        return view('pages.deals', [
            'deals' => $deals,
        ]);
    }
}
