<?php

it('has questions page - response test', function () {
    $response = $this->get('/questions');

    $response->assertStatus(200);
});

it('has question page - response test', function () {
    $response = $this->get('/question/1');

    $response->assertStatus(200);
});
