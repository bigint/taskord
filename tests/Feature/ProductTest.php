<?php

it('has products page - response test', function () {
    $response = $this->get('/products');

    $response->assertStatus(200);
});

it('has product page - done - response test', function () {
    $response = $this->get('/product/taskord');

    $response->assertStatus(200);
});

it('has product page - pending - response test', function () {
    $response = $this->get('/product/taskord/pending');

    $response->assertStatus(200);
});

it('has product page - updates - response test', function () {
    $response = $this->get('/product/taskord/updates');

    $response->assertStatus(200);
});

// FIX This
// it('has product page - rss', function () {
//     $response = $this->get('/feed/product/taskord');

//     $response->assertStatus(200);
// });
