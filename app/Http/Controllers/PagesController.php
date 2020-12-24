<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    public function deals()
    {
        $deals = Deal::cacheFor(60 * 60)->get();

        return view('pages.deals', [
            'deals' => $deals,
        ]);
    }

    public function open()
    {
        return view('pages.open');
    }

    public function reputation()
    {
        $points = DB::table('reputations')
            ->where('payee_id', Auth::id())
            ->latest()
            ->paginate(50);

        return view('pages.reputation', [
            'points' => $points,
        ]);
    }
}
