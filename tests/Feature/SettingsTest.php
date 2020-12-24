<?php

use function Tests\actingAs;

// Unauth

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

it('has settings page - logs - unauth - response test', function () {
    $response = $this->get('/settings/logs');

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

// Auth

it('has settings page - profile - auth - response test', function () {
    actingAs(1)->get('/settings')->assertStatus(200);
});

it('has settings page - account - auth - response test', function () {
    actingAs(1)->get('/settings/account')->assertStatus(200);
});

it('has settings page - patron - auth - response test', function () {
    actingAs(1)->get('/settings/patron')->assertStatus(200);
});

it('has settings page - password - auth - response test', function () {
    actingAs(1)->get('/settings/password')->assertStatus(200);
});

it('has settings page - notifications - auth - response test', function () {
    actingAs(1)->get('/settings/notifications')->assertStatus(200);
});

it('has settings page - integrations - auth - response test', function () {
    actingAs(1)->get('/settings/integrations')->assertStatus(200);
});

it('has settings page - api - auth - response test', function () {
    actingAs(1)->get('/settings/api')->assertStatus(200);
});

it('has settings page - logs - auth - response test', function () {
    actingAs(1)->get('/settings/logs')->assertStatus(200);
});

it('has settings page - data - auth - response test', function () {
    actingAs(1)->get('/settings/data')->assertStatus(200);
});

it('has settings page - delete - auth - response test', function () {
    actingAs(1)->get('/settings/delete')->assertStatus(200);
});
