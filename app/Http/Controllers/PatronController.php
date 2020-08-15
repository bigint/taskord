<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PatronController extends Controller
{
    public function success(Request $request)
    {
        dd('yo');

        return response()->json(['success' => 'success'], 200);
    }

    public function patron()
    {
        return view('pages.patron');
    }
}
