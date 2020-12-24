<?php

use App\Models\User;
use function Tests\actingAs;

it('has deals page - response test', function () {
    $this->get('/deals')->assertStatus(200);
    actingAs(1)->get('/deals')->assertStatus(200);
});

it('has sponsors page - response test', function () {
    $this->get('/sponsors')->assertStatus(200);
    actingAs(1)->get('/sponsors')->assertStatus(200);
});

it('has about page - response test', function () {
    $this->get('/about')->assertStatus(200);
    actingAs(1)->get('/about')->assertStatus(200);
});

it('has contact page - response test', function () {
    $this->get('/contact')->assertStatus(200);
    actingAs(1)->get('/contact')->assertStatus(200);
});

it('has open page - response test', function () {
    $this->get('/open')->assertStatus(200);
    actingAs(1)->get('/open')->assertStatus(200);
});

it('has patron page - response test', function () {
    $this->get('/patron')->assertStatus(200);
    actingAs(1)->get('/patron')->assertStatus(200);
});

it('has privacy page - response test', function () {
    $this->get('/privacy')->assertStatus(200);
    actingAs(1)->get('/privacy')->assertStatus(200);
});

it('has security page - response test', function () {
    $this->get('/security')->assertStatus(200);
    actingAs(1)->get('/security')->assertStatus(200);
});

it('has reputation page - response test', function () {
    $this->get('/reputation')->assertStatus(302);
    actingAs(1)->get('/reputation')->assertStatus(200);
});
