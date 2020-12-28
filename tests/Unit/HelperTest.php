<?php

namespace Tests\Unit;

use App\Helpers\Helper;
use Illuminate\Mail\Markdown;

test('can get correct usernames from mentions', function($text, $expected) {
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

test('parsedown parses links correctly', function ($markdown, $expected) {
    expect(trim(Markdown::parse($markdown)))->toEqual($expected);
})->with([
    ['[@te-st](/@te-st) [@ad_min](/@ad_min)', '<p><a href="/@te-st">@te-st</a> <a href="/@ad_min">@ad_min</a></p>'],
    ['[@test](/@test) [@ad_min](/@ad_min)', '<p><a href="/@test">@test</a> <a href="/@ad_min">@ad_min</a></p>'],
    ['[@test](/@test) @ad_min', '<p><a href="/@test">@test</a> @ad_min</p>'],
    ['[@te-st](/@te-st)', '<p><a href="/@te-st">@te-st</a></p>']
]);
