<?php

it('has products page - response test', function () {
    $this->get('/products')->assertStatus(200);
    actingAs(1)->get('/products')->assertStatus(200);
});

it('has product page - done - response test', function () {
    $this->get('/product/taskord')->assertStatus(200);
    actingAs(1)->get('/product/taskord')->assertStatus(200);
});

it('has product page - pending - response test', function () {
    $this->get('/product/taskord/pending')->assertStatus(200);
    actingAs(1)->get('/product/taskord/pending')->assertStatus(200);
});

it('has product page - updates - response test', function () {
    $this->get('/product/taskord/updates')->assertStatus(200);
    actingAs(1)->get('/product/taskord/updates')->assertStatus(200);
});

// FIX This
// it('has product page - rss', function () {
//     $this->get('/feed/product/taskord');

//     $response->assertStatus(200);
// });
