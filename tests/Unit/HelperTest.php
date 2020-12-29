<?php

namespace Tests\Unit;

use App\Helpers\Helper;
use Illuminate\Support\Facades\App;

test('can convert to CDN url in production enviroment with arguments', function($url, $resolution, $expected) {
    App::shouldReceive('environment')->once()->withNoArgs()->andReturn('production');

    expect(Helper::getCDNImage($url, $resolution))->toEqual($expected);
})->with([
    ['https://taskord.com/storage/test.png', 500, 'https://ik.imagekit.io/blbrg3136a/tr:w-500/test.png'],
    ['https://taskord.com/storage/test.png', 501, 'https://ik.imagekit.io/blbrg3136a/tr:w-501/test.png'],
]);

test('can convert to CDN url in production enviroment without arguments', function() {
    App::shouldReceive('environment')->once()->withNoArgs()->andReturn('production');

    $urlFromHelper = Helper::getCDNImage('https://taskord.com/storage/test.png');

    expect($urlFromHelper)->toEqual('https://ik.imagekit.io/blbrg3136a/tr:w-500/test.png');
});

test('can get correct usernames from mentions', function ($text, $expected) {
    $usernames = Helper::getUsernamesFromMentions($text);

    expect($usernames)->toMatchArray($expected);
})->with([
    ['Hello @test and @admin', ['test', 'admin']],
    ['@test @adm_in', ['test', 'adm_in']],
    ['@test @admin', ['test', 'admin']],
    ['Hello @te-st', ['te-st']],
    ['@te-st', ['te-st']],
    ['@test', ['test']],
]);

test('can return empty array if no user mentions are found', function () {
    $usernames = Helper::getUsernamesFromMentions('no users found');

    expect($usernames)->toBeEmpty();
});

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

test('can return empty array if no product mentions are found', function () {
    $products = Helper::getProductIDFromMention('no users found');

    expect($products)->toBeEmpty();
});

test('can render task with user mentions correctly', function ($task, $expected) {
    expect(Helper::renderTask($task))->toEqual($expected);
})->with([
    ['@test @admin', '<a href="/@test">@test</a> <a href="/@admin">@admin</a>'],
    ['@test admin', '<a href="/@test">@test</a> admin'],
    ['Hello @test', 'Hello <a href="/@test">@test</a>'],
    ['@te_st', '<a href="/@te_st">@te_st</a>'],
    ['@te-st', '<a href="/@te-st">@te-st</a>'],
    ['@test', '<a href="/@test">@test</a>'],
]);

test('can render task with product mentions correctly', function ($task, $expected) {
    expect(Helper::renderTask($task))->toEqual($expected);
})->with([
    ['#test #admin', '<a href="/product/test">#test</a> <a href="/product/admin">#admin</a>'],
    ['#test admin', '<a href="/product/test">#test</a> admin'],
    ['Hello #test', 'Hello <a href="/product/test">#test</a>'],
    ['#te_st', '<a href="/product/te_st">#te_st</a>'],
    ['#te-st', '<a href="/product/te-st">#te-st</a>'],
    ['#test', '<a href="/product/test">#test</a>'],
]);
