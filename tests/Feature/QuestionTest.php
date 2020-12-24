<?php

use function Tests\actingAs;

it('has questions page - response test', function () {
    $this->get('/questions')->assertStatus(200);
    actingAs(1)->get('/questions')->assertStatus(200);
});

it('has question page - response test', function () {
    $this->get('/question/1')->assertStatus(200);
    actingAs(1)->get('/question/1')->assertStatus(200);
});
