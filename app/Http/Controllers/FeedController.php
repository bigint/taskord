<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class FeedController extends Controller
{
    public function user($username)
    {
        $user = User::where('username', $username)
            ->firstOrFail();

        $content = view('feed.user', [
            'user' => $user,
        ]);

        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }
}
