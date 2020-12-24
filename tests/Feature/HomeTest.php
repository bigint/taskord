<?php

use function Tests\actingAs;

it('has home page - response test', function () {
    $this->get('/')->assertStatus(200);
    actingAs(1)->get('/')->assertStatus(200);
});
