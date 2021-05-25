<?php

it('has stafftools page', function ($url, $expected) {
    $this->get($url)->assertStatus($expected);
})->with([
    ['/stafftools', 404, false],
]);

it('has stafftools/users page', function ($url, $expected) {
    $this->get($url)->assertStatus($expected);
})->with([
    ['/stafftools/users', 404, false],
]);

it('has stafftools/tasks page', function ($url, $expected) {
    $this->get($url)->assertStatus($expected);
})->with([
    ['/stafftools/tasks', 404, false],
]);

it('has stafftools/activities page', function ($url, $expected) {
    $this->get($url)->assertStatus($expected);
})->with([
    ['/stafftools/activities', 404, false],
]);

it('has stafftools/products page', function ($url, $expected) {
    $this->get($url)->assertStatus($expected);
})->with([
    ['/stafftools/products', 404, false],
]);

it('has stafftools/system page', function ($url, $expected) {
    $this->get($url)->assertStatus($expected);
})->with([
    ['/stafftools/system', 404, false],
]);

it('has stafftools/features page', function ($url, $expected) {
    $this->get($url)->assertStatus($expected);
})->with([
    ['/stafftools/features', 404, false],
]);

it('has stafftools/jobs page', function ($url, $expected) {
    $this->get($url)->assertStatus($expected);
})->with([
    ['/stafftools/jobs', 404, false],
]);
