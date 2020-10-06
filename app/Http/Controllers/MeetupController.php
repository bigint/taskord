<?php

namespace App\Http\Controllers;

use App\Models\Meetup;

class MeetupController extends Controller
{
    public function meetups()
    {
        $meetups = Meetup::cacheFor(60 * 60)
            ->where('starts_at', '>=', date('Y-m-d'))
            ->orderBy('starts_at')
            ->get();

        return view('meetups.meetups', [
            'meetups' => $meetups,
        ]);
    }
}
