<?php

namespace App\Http\Controllers;

class NotificationController extends Controller
{
    public function unread()
    {
        return view('notifications.unread');
    }

    public function all()
    {
        return view('notifications.all');
    }
}
