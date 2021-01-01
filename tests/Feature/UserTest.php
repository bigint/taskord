<?php

use function Tests\actingAs;

it('has user done page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/@test', 200, false],
    ['/@test', 200, true],
]);

it('has user pending page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/@test/pending', 200, false],
    ['/@test/pending', 200, true],
]);

it('has user products page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/@test/products', 200, false],
    ['/@test/products', 200, true],
]);

it('has user questions page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/@test/questions', 200, false],
    ['/@test/questions', 200, true],
]);

it('has user answers page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/@test/answers', 200, false],
    ['/@test/answers', 200, true],
]);

it('has user stats page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/@test/stats', 200, false],
    ['/@test/stats', 200, true],
]);

it('has user popover', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/popover/user/1', 200, false],
    ['/popover/user/1', 200, true],
]);
