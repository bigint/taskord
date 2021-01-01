<?php

it('has admin/users page', function ($url, $expected) {
    $this->get($url)->assertStatus($expected);
})->with([
    ['/admin/users', 302, false],
]);

it('has admin/tasks page', function ($url, $expected) {
    $this->get($url)->assertStatus($expected);
})->with([
    ['/admin/tasks', 302, false],
]);

it('has admin/activities page', function ($url, $expected) {
    $this->get($url)->assertStatus($expected);
})->with([
    ['/admin/activities', 302, false],
]);
