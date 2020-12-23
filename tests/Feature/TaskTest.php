<?php

it('has task page - response test', function () {
    $response = $this->get('/task/1');

    $response->assertStatus(200);
});
