<?php

namespace App\Http\Controllers;

use App\Models\Meetup;
use Illuminate\Contracts\View\View;

class MeetupController extends Controller
{
    public function meetups(): View
    {
        $meetups = Meetup::where('date', '>=', date('Y-m-d'))
            ->orderBy('date')
            ->paginate(12);

        return view('meetups.meetups', [
            'type' => 'meetups.upcoming',
            'meetups' => $meetups,
        ]);
    }

    public function finished(): View
    {
        $meetups = Meetup::where('date', '<=', date('Y-m-d'))
            ->latest()
            ->paginate(12);

        return view('meetups.meetups', [
            'type' => 'meetups.finished',
            'meetups' => $meetups,
        ]);
    }

    public function rsvpd(): View
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
