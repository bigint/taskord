<?php

namespace App\Http\Controllers;

use App\Models\Meetup;
use Illuminate\Support\Facades\Auth;

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

    public function finished()
    {
        $meetups = Meetup::cacheFor(60 * 60)
            ->where('date', '<=', date('Y-m-d'))
            ->latest()
            ->paginate(12);

        return view('meetups.finished', [
            'meetups' => $meetups,
        ]);
    }

    public function rsvpd()
    {
        $meetups = Auth::user()->subscriptions(Meetup::class)
            ->orderBy('date')
            ->get();

        return view('meetups.rsvpd', [
            'meetups' => $meetups,
        ]);
    }
}
