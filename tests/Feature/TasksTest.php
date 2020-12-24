<?php

use function Tests\actingAs;

it('has tasks page - unauth - response test', function () {
    $response = $this->get('/tasks');

    $response->assertStatus(302);
});

it('has tasks page - auth - response test', function () {
    actingAs(1)->get('/tasks')->assertStatus(200);
});
