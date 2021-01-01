<?php

use function Tests\actingAs;

it('has home page', function ($url, $expected, $auth) {
    if ($auth) {
        $this->get($url)->assertStatus($expected);
    } else {
        actingAs(1)->get($url)->assertStatus($expected);
    }
})->with([
    ['/', 200, false],
    ['/', 200, true],
]);
