<?php

use function Tests\actingAs;

it('has comment page', function ($url, $expected, $auth) {
    if ($auth) {
        $this->get($url)->assertStatus($expected);
    } else {
        actingAs(1)->get($url)->assertStatus($expected);
    }
})->with([
    ['/task/1/1', 200, false],
    ['/task/1/1', 200, true],
]);
