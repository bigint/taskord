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

it('has deployment data details skeleton', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/site/deployment-data', 404, false],
    ['/site/deployment-data', 200, true],
]);

it('has commit data details skeleton', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/site/commit-data', 404, false],
    ['/site/commit-data', 200, true],
]);
