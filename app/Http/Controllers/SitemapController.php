<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SitemapController extends Controller
{
    public function users()
    {
        $users = User::all();
        
        return view('seo.sitemap_users', [
            'users' => $users,
        ]);
    }
}
