<?php

use function Tests\actingAs;

it('has questions page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/questions', 200, false],
    ['/questions', 200, true],
]);

it('has single question page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/question/1', 200, false],
    ['/question/1', 200, true],
]);
