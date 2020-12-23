<?php

it('has settings page - profile - unauth - response test', function () {
    $response = $this->get('/settings');

    $response->assertStatus(302);
});

it('has settings page - account - unauth - response test', function () {
    $response = $this->get('/settings/account');

    $response->assertStatus(302);
});

it('has settings page - patron - unauth - response test', function () {
    $response = $this->get('/settings/patron');

    $response->assertStatus(302);
});

it('has settings page - password - unauth - response test', function () {
    $response = $this->get('/settings/password');

    $response->assertStatus(302);
});

it('has settings page - notifications - unauth - response test', function () {
    $response = $this->get('/settings/notifications');

    $response->assertStatus(302);
});

it('has settings page - integrations - unauth - response test', function () {
    $response = $this->get('/settings/integrations');

    $response->assertStatus(302);
});

it('has settings page - api - unauth - response test', function () {
    $response = $this->get('/settings/api');

    $response->assertStatus(302);
});

it('has settings page - data - unauth - response test', function () {
    $response = $this->get('/settings/data');

    $response->assertStatus(302);
});

it('has settings page - delete - unauth - response test', function () {
    $response = $this->get('/settings/delete');

    $response->assertStatus(302);
});
