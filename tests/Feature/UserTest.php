<?php

it('has profile page - done - response test', function () {
    $response = $this->get('/@test');

    $response->assertStatus(200);
});

it('has profile page - pending - response test', function () {
    $response = $this->get('/@test/pending');

    $response->assertStatus(200);
});

it('has profile page - products - response test', function () {
    $response = $this->get('/@test/products');

    $response->assertStatus(200);
});

it('has profile page - questions - response test', function () {
    $response = $this->get('/@test/questions');

    $response->assertStatus(200);
});

it('has profile page - answers - response test', function () {
    $response = $this->get('/@test/answers');

    $response->assertStatus(200);
});

// FIX This
// it('has profile page - rss - response test', function () {
//     $response = $this->get('/feed/user/test');

//     $response->assertStatus(200);
// });
