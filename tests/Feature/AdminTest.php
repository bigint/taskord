<?php

use function Tests\actingAs;
use Illuminate\Foundation\Testing\WithoutMiddleware;

it('has admin/users page - response test', function () {
    $this->get('/admin/users')->assertStatus(302);
});

it('has admin/tasks page - response test', function () {
    $this->get('/admin/tasks')->assertStatus(302);
});

it('has admin/activities page - response test', function () {
    $this->get('/admin/activities')->assertStatus(302);
});
