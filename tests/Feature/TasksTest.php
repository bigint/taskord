<?php

use App\Models\User;
use function Tests\actingAs;

it('has tasks page - unauth - response test', function () {
    $response = $this->get('/tasks');

    $response->assertStatus(302);
});

it('has tasks page - auth - response test', function () {
    define('LARAVEL_START', microtime(true));
    $user = User::find(1)->first();

    actingAs($user)->get('/tasks')->assertStatus(200);
});
