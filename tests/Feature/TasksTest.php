<?php

use function Tests\actingAs;

it('has tasks page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/tasks', 302, false],
    ['/tasks', 200, true],
]);
