<?php

it('has tasks page - unauth - response test', function () {
    $response = $this->get('/tasks');

    $response->assertStatus(302);
});
