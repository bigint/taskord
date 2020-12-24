<?php

namespace Tests;

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
    return test()->actingAs(User::find($user)->first(), $driver);
}
