<?php

use function Tests\actingAs;

it('has tasks page - response test', function () {
    $this->get('/tasks')->assertStatus(302);
    actingAs(1)->get('/tasks')->assertStatus(200);
});
