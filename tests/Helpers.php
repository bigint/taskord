<?php

namespace Tests;

use Illuminate\Contracts\Auth\Authenticatable;
use App\Models\User;

/**
 * A basic assert example.
 */
function assertExample(): void
{
    test()->assertTrue(true);
}

function actingAs($user = 1, string $driver = null)
{
    define('LARAVEL_START', microtime(true));
    return test()->actingAs(User::find($user)->first(), $driver);
}
