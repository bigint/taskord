<?php

namespace App\Http\Controllers;

class PatronController extends Controller
{
    public function tier($id)
    {
        if ($id < 1 or $id > 4) {
            return view('errors.404');
        }

        return view('pages.patron.tier', [
            'tier' => $id,
        ]);
    }

    public function patron()
    {
        return view('pages.patron.patron');
    }
}
