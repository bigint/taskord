<?php

namespace App\Http\Controllers;

use App\Models\Meetup;

class MeetupController extends Controller
{
    public function meetups()
    {
        $meetups = Meetup::where('date', '>=', date('Y-m-d'))
            ->orderBy('date')
            ->paginate(12);

        return view('meetups.meetups', [
            'type' => 'meetups.upcoming',
            'meetups' => $meetups,
        ]);
    }

    public function finished()
    {
        $meetups = Meetup::where('date', '<=', date('Y-m-d'))
            ->latest()
            ->paginate(12);

        return view('meetups.meetups', [
            'type' => 'meetups.finished',
            'meetups' => $meetups,
        ]);
    }

    public function rsvpd()
    {
        $meetups = auth()->user()->subscriptions(Meetup::class)
            ->orderBy('date')
            ->get();

        return view('meetups.meetups', [
            'type' => 'meetups.rsvpd',
            'meetups' => $meetups,
        ]);
    }
}
