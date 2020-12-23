<?php

it('has profile page - done', function () {
    $response = $this->get('/@test');

    $response->assertStatus(200);
});

it('has profile page - pending', function () {
    $response = $this->get('/@test/pending');

    $response->assertStatus(200);
});

it('has profile page - products', function () {
    $response = $this->get('/@test/products');

    $response->assertStatus(200);
});

it('has profile page - questions', function () {
    $response = $this->get('/@test/questions');

    $response->assertStatus(200);
});

it('has profile page - answers', function () {
    $response = $this->get('/@test/answers');

    $response->assertStatus(200);
});

it('has profile page - rss', function () {
    $response = $this->get('/feed/user/test');

    $response->assertStatus(200);
});
