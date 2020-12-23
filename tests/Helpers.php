<?php

namespace Tests;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 * A basic assert example.
 */
function assertExample(): void
{
    test()->assertTrue(true);
}

function actingAs(Authenticatable $user, string $driver = null)
{
    return test()->actingAs($user, $driver);
}
