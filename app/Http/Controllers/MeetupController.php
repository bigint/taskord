<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meetup;

class MeetupController extends Controller
{
    public function meetups()
    {
        $meetups = Meetup::cacheFor(60 * 60)->get();

        return view('meetups.meetups', [
            'meetups' => $meetups,
        ]);
    }
}
