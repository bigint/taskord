<?php

namespace Tests\Unit;

use App\Helpers\Helper;
use Carbon\Carbon;
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

test('can render task with both user and product mentions correctly', function ($task, $expected) {
    expect(Helper::renderTask($task))->toEqual($expected);
})->with([
    ['#test admin @te-st', '<a href="/product/test">#test</a> admin <a href="/@te-st">@te-st</a>'],
    ['Hello #test @te-st', 'Hello <a href="/product/test">#test</a> <a href="/@te-st">@te-st</a>'],
    ['#te_st @te_st', '<a href="/product/te_st">#te_st</a> <a href="/@te_st">@te_st</a>'],
    ['#te-st @te-st', '<a href="/product/te-st">#te-st</a> <a href="/@te-st">@te-st</a>'],
    ['#test @test', '<a href="/product/test">#test</a> <a href="/@test">@test</a>'],
]);

test('can render due date correctly' , function ($days, $expected) {
    $date = Carbon::now()->addDays($days);
    $expect = str_replace('-format-', $date->format('M d, Y'), $expected);

    expect(Helper::renderDueDate($date))->toEqual($expect);
})->with([
    [0, "<span title='-format-' class='me-2 text-danger'>Due today</span>"],
    [1, "<span title='-format-' class='me-2 text-info'>Due tomorrow</span>"],
    [2, "<span title='-format-' class='me-2 text-success'>Due in 2 days</span>"],
    [3, "<span title='-format-' class='me-2 text-success'>Due in 3 days</span>"],
    [-2, "<span title='-format-' class='me-2 text-danger'>Overdue by 1 day</span>"],
    [-3, "<span title='-format-' class='me-2 text-danger'>Overdue by 2 days</span>"],
    [-4, "<span title='-format-' class='me-2 text-danger'>Overdue by 3 days</span>"],
]);
