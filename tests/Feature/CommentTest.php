<?php

use function Tests\actingAs;

it('has comment page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/task/1/1', 200, false],
    ['/task/1/1', 200, true],
]);
