<?php

it('has comment page - response test', function () {
    $response = $this->get('/task/1/1');

    $response->assertStatus(200);
});
