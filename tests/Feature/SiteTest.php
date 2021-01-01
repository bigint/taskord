<?php

use function Tests\actingAs;

it('has keyboard shortcuts skeleton', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/site/shortcuts', 302, false],
    ['/site/shortcuts', 200, true],
]);
