<?php

namespace App\Http\Controllers;

use App\Models\Meetup;

class MeetupController extends Controller
{
    public function meetups()
    {
        $meetups = Meetup::cacheFor(60 * 60)
            ->where('date', '>=', date('Y-m-d'))
            ->orderBy('date')
            ->paginate(12);

        return view('meetups.meetups', [
            'meetups' => $meetups,
        ]);
    }

    public function rsvpd()
    {
        $meetups = Meetup::cacheFor(60 * 60)
            ->where('date', '>=', date('Y-m-d'))
            ->orderBy('date')
            ->paginate(12);

        return view('meetups.rsvpd', [
            'meetups' => $meetups,
        ]);
    }
}
