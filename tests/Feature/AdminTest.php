<?php

it('has stafftools page', function ($url, $expected) {
    $this->get($url)->assertStatus($expected);
})->with([
    ['/stafftools', 302, false],
]);

it('has stafftools/users page', function ($url, $expected) {
    $this->get($url)->assertStatus($expected);
})->with([
    ['/stafftools/users', 302, false],
]);

it('has stafftools/tasks page', function ($url, $expected) {
    $this->get($url)->assertStatus($expected);
})->with([
    ['/stafftools/tasks', 302, false],
]);

it('has stafftools/activities page', function ($url, $expected) {
    $this->get($url)->assertStatus($expected);
})->with([
    ['/stafftools/activities', 302, false],
]);

it('has stafftools/products page', function ($url, $expected) {
    $this->get($url)->assertStatus($expected);
})->with([
    ['/stafftools/products', 302, false],
]);

it('has stafftools/system page', function ($url, $expected) {
    $this->get($url)->assertStatus($expected);
})->with([
    ['/stafftools/system', 302, false],
]);

it('has stafftools/features page', function ($url, $expected) {
    $this->get($url)->assertStatus($expected);
})->with([
    ['/stafftools/features', 302, false],
]);
