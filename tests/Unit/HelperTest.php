<?php

namespace Tests\Unit;

use App\Helpers\Helper;
use Illuminate\Support\Facades\App;

test('can convert to CDN url in production enviroment', function($url, $resolution, $expected) {
    App::shouldReceive('environment')->once()->withNoArgs()->andReturn('production');

    expect(Helper::getCDNImage($url, $resolution))->toEqual($expected);
})->with([
    ['https://taskord.com/storage/test.png', 500, 'https://ik.imagekit.io/blbrg3136a/tr:w-500/test.png']
]);

test('can get correct usernames from mentions', function ($text, $expected) {
    $usernames = Helper::getUserIDFromMention($text);

    expect($usernames)->toMatchArray($expected);
})->with([
    ['Hello @test and @admin', ['test', 'admin']],
    ['@test @adm_in', ['test', 'adm_in']],
    ['@test @admin', ['test', 'admin']],
    ['Hello @te-st', ['te-st']],
    ['@te-st', ['te-st']],
    ['@test', ['test']],
]);

test('can parse mentions to markdown', function (
    string $markdown,
    array $mentions,
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
