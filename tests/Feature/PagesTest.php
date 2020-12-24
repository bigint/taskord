<?php

it('has deals page - response test', function () {
    $response = $this->get('/deals');

    $response->assertStatus(200);
});

it('has sponsors page - response test', function () {
    $response = $this->get('/sponsors');

    $response->assertStatus(200);
});

it('has about page - response test', function () {
    $response = $this->get('/about');

    $response->assertStatus(200);
});

it('has contact page - response test', function () {
    $response = $this->get('/contact');

    $response->assertStatus(200);
});

it('has open page - response test', function () {
    $response = $this->get('/open');

    $response->assertStatus(200);
});

it('has patron page - response test', function () {
    $response = $this->get('/patron');

    $response->assertStatus(200);
});

it('has privacy page - response test', function () {
    $response = $this->get('/privacy');

    $response->assertStatus(200);
});

it('has reputation page - unauth - response test', function () {
    $response = $this->get('/reputation');

    $response->assertStatus(302);
});

it('has security page - response test', function () {
    $response = $this->get('/security');

    $response->assertStatus(200);
});
