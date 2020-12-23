<?php

it('has home page - response test', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
