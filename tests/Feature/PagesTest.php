<?php

use function Tests\actingAs;

it('has deals page', function ($url, $expected, $auth) {
    if ($auth) {
        $this->get($url)->assertStatus($expected);
    } else {
        actingAs(1)->get($url)->assertStatus($expected);
    }
})->with([
    ['/deals', 200, false],
    ['/deals', 200, true],
]);

it('has sponsors page', function ($url, $expected, $auth) {
    if ($auth) {
        $this->get($url)->assertStatus($expected);
    } else {
        actingAs(1)->get($url)->assertStatus($expected);
    }
})->with([
    ['/sponsors', 200, false],
    ['/sponsors', 200, true],
]);

it('has about page', function ($url, $expected, $auth) {
    if ($auth) {
        $this->get($url)->assertStatus($expected);
    } else {
        actingAs(1)->get($url)->assertStatus($expected);
    }
})->with([
    ['/about', 200, false],
    ['/about', 200, true],
]);

it('has contact page', function ($url, $expected, $auth) {
    if ($auth) {
        $this->get($url)->assertStatus($expected);
    } else {
        actingAs(1)->get($url)->assertStatus($expected);
    }
})->with([
    ['/contact', 200, false],
    ['/contact', 200, true],
]);

it('has open page', function ($url, $expected, $auth) {
    if ($auth) {
        $this->get($url)->assertStatus($expected);
    } else {
        actingAs(1)->get($url)->assertStatus($expected);
    }
})->with([
    ['/open', 200, false],
    ['/open', 200, true],
]);

it('has patron page', function ($url, $expected, $auth) {
    if ($auth) {
        $this->get($url)->assertStatus($expected);
    } else {
        actingAs(1)->get($url)->assertStatus($expected);
    }
})->with([
    ['/patron', 200, false],
    ['/patron', 200, true],
]);

it('has privacy page', function ($url, $expected, $auth) {
    if ($auth) {
        $this->get($url)->assertStatus($expected);
    } else {
        actingAs(1)->get($url)->assertStatus($expected);
    }
})->with([
    ['/privacy', 200, false],
    ['/privacy', 200, true],
]);

it('has security page', function ($url, $expected, $auth) {
    if ($auth) {
        $this->get($url)->assertStatus($expected);
    } else {
        actingAs(1)->get($url)->assertStatus($expected);
    }
})->with([
    ['/security', 200, false],
    ['/security', 200, true],
]);

it('has reputation page', function ($url, $expected, $auth) {
    if ($auth) {
        $this->get($url)->assertStatus($expected);
    } else {
        actingAs(1)->get($url)->assertStatus($expected);
    }
})->with([
    ['/reputation', 302, false],
    ['/reputation', 200, true],
]);
