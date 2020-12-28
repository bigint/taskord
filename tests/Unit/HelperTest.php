<?php

namespace Tests\Unit;

use App\Helpers\Helper;

test('can parse mentions to markdown', function(
    string $markdown,
    array  $mentions,
    string $expected
) {
    $parsed = Helper::parseUserMentionsToMarkdownLinks($markdown, $mentions);

    expect($parsed)->toEqual($expected);
})->with([
    ['@test @ad_min', ['ad_min', 'test'], '[@test](/@test) [@ad_min](/@ad_min)'],
    ['@test @admin', ['test', 'admin'], '[@test](/@test) [@admin](/@admin)'],
    ['@test @admin', ['test'], '[@test](/@test) @admin'],
    ['Hello @test', ['test'], 'Hello [@test](/@test)'],
    ['@ad_min', ['ad_min'], '[@ad_min](/@ad_min)'],
    ['@te-st', ['te-st'], '[@te-st](/@te-st)'],
    ['@test', ['test'], '[@test](/@test)'],
]);
