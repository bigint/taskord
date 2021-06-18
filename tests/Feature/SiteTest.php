<?php

use function Tests\actingAs;

it('has keyboard shortcuts skeleton', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/site/shortcuts', 200, false],
    ['/site/shortcuts', 200, true],
]);

it('has ci data details skeleton', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/site/ci-data', 404, false],
    ['/site/ci-data', 200, true],
]);

it('has commits data details skeleton', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/site/commits-data', 404, false],
    ['/site/commits-data', 200, true],
]);
