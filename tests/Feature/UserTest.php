<?php

use function Tests\actingAs;

it('has profile page - done - response test', function () {
    $this->get('/@test')->assertStatus(200);
    actingAs(1)->get('/@test')->assertStatus(200);
});

it('has profile page - pending - response test', function () {
    $this->get('/@test/pending')->assertStatus(200);
    actingAs(1)->get('/@test/pending')->assertStatus(200);
});

it('has profile page - products - response test', function () {
    $this->get('/@test/products')->assertStatus(200);
    actingAs(1)->get('/@test/products')->assertStatus(200);
});

it('has profile page - questions - response test', function () {
    $this->get('/@test/questions')->assertStatus(200);
    actingAs(1)->get('/@test/questions')->assertStatus(200);
});

it('has profile page - answers - response test', function () {
    $this->get('/@test/answers')->assertStatus(200);
    actingAs(1)->get('/@test/answers')->assertStatus(200);
});

it('has user popover - response test', function () {
    $this->get('/popover/user/1')->assertStatus(200);
    actingAs(1)->get('/popover/user/1')->assertStatus(200);
});
