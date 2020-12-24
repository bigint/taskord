<?php

use function Tests\actingAs;

it('has settings page - profile - response test', function () {
    $this->get('/settings')->assertStatus(302);
    actingAs(1)->get('/settings')->assertStatus(200);
});

it('has settings page - account - response test', function () {
    $this->get('/settings/account')->assertStatus(302);
    actingAs(1)->get('/settings/account')->assertStatus(200);
});

it('has settings page - patron - response test', function () {
    $this->get('/settings/patron')->assertStatus(302);
    actingAs(1)->get('/settings/patron')->assertStatus(200);
});

it('has settings page - password - response test', function () {
    $this->get('/settings/password')->assertStatus(302);
    actingAs(1)->get('/settings/password')->assertStatus(200);
});

it('has settings page - notifications - response test', function () {
    $this->get('/settings/notifications')->assertStatus(302);
    actingAs(1)->get('/settings/notifications')->assertStatus(200);
});

it('has settings page - integrations - response test', function () {
    $this->get('/settings/integrations')->assertStatus(302);
    actingAs(1)->get('/settings/integrations')->assertStatus(200);
});

it('has settings page - api - response test', function () {
    $this->get('/settings/api')->assertStatus(302);
    actingAs(1)->get('/settings/api')->assertStatus(200);
});

it('has settings page - logs - response test', function () {
    $this->get('/settings/logs')->assertStatus(302);
    actingAs(1)->get('/settings/logs')->assertStatus(200);
});

it('has settings page - data - response test', function () {
    $this->get('/settings/data')->assertStatus(302);
    actingAs(1)->get('/settings/data')->assertStatus(200);
});

it('has settings page - delete - response test', function () {
    $this->get('/settings/delete')->assertStatus(302);
    actingAs(1)->get('/settings/delete')->assertStatus(200);
});
