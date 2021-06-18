<?php

use App\Http\Controllers\FeedController;
use App\Http\Controllers\MeetupController;
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PatronController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth
Auth::routes();
Auth::routes(['verify' => true]);

// Social Auth
Route::get('login/{provider}', [SocialController::class, 'redirect']);
Route::get('login/{provider}/callback', [SocialController::class, 'callback']);

// 404 Fallback
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

// Suspended
Route::view('suspended', 'auth.suspended')
    ->name('suspended');

// Home/Dashboard/Landing
Route::view('/', 'home.home')->name('home');

// Explore
Route::group(['prefix' => 'explore', 'as' => 'explore.'], function () {
    Route::view('', 'explore.explore')
        ->name('explore');
    Route::view('/makers', 'explore.makers')
        ->middleware('feature:explore_makers')
        ->name('makers');
});

// User
Route::group(['prefix' => '@{username}', 'as' => 'user.'], function () {
    Route::get('', [UserController::class, 'profile'])
        ->name('done');
    Route::get('pending', [UserController::class, 'profile'])
        ->name('pending');
    Route::get('products', [UserController::class, 'profile'])
        ->name('products');
    Route::get('questions', [UserController::class, 'profile'])
        ->name('questions');
    Route::get('answers', [UserController::class, 'profile'])
        ->name('answers');
    Route::get('milestones', [UserController::class, 'profile'])
        ->name('milestones');
    Route::get('following', [UserController::class, 'profile'])
        ->name('following');
    Route::get('followers', [UserController::class, 'profile'])
        ->name('followers');
    Route::get('stats', [UserController::class, 'profile'])
        ->name('stats');
    Route::get('/json', [UserController::class, 'json'])
        ->name('json');
});

// Settings
Route::group([
    'prefix' => 'settings',
    'as' => 'user.settings.',
    'middleware' => ['auth'],
], function () {
    Route::get('', [UserController::class, 'profileSettings'])
        ->name('profile');
    Route::get('account', [UserController::class, 'accountSettings'])
        ->name('account');
    Route::get('appearance', [UserController::class, 'appearanceSettings'])
        ->name('appearance');
    Route::get('products', [UserController::class, 'productsSettings'])
        ->name('products');
    Route::get('patron', [UserController::class, 'patronSettings'])
        ->name('patron');
    Route::get('password', [UserController::class, 'passwordSettings'])
        ->name('password');
    Route::get('notifications', [UserController::class, 'notifySettings'])
        ->name('notifications');
    Route::get('integrations', [UserController::class, 'integrationsSettings'])
        ->name('integrations');
    Route::get('api', [UserController::class, 'apiSettings'])
        ->name('api');
    Route::get('sessions', [UserController::class, 'sessionsSettings'])
        ->name('sessions');
    Route::get('logs', [UserController::class, 'logsSettings'])
        ->name('logs');
    Route::get('data', [UserController::class, 'dataSettings'])
        ->name('data');
    Route::get('delete', [UserController::class, 'deleteSettings'])
        ->name('delete');
    Route::get('export/account', [UserController::class, 'exportAccount'])
        ->name('export.account');
    Route::get('export/logs', [UserController::class, 'exportLogs'])
        ->name('export.logs');
});

// Notifications
Route::group([
    'prefix' => 'notifications',
    'as' => 'notifications.',
    'middleware' => ['auth'],
], function () {
    Route::view('', 'notifications.unread')
        ->name('unread');
    Route::view('all', 'notifications.all')
        ->name('all');
});

// Webhooks
Route::group(['prefix' => 'webhook'], function () {
    Route::post('web/{token}', [WebhookController::class, 'web']);
});

// Product
Route::group(['prefix' => 'product/{slug}', 'as' => 'product.'], function () {
    Route::get('', [ProductController::class, 'profile'])
        ->name('done');
    Route::get('pending', [ProductController::class, 'profile'])
        ->name('pending');
    Route::get('updates', [ProductController::class, 'profile'])
        ->name('updates');
    Route::get('subscribers', [ProductController::class, 'profile'])
        ->name('subscribers');
    Route::get('edit', [ProductController::class, 'edit'])
        ->middleware('auth')
        ->name('edit');
    Route::get('verify', [ProductController::class, 'verify'])
        ->middleware('auth')
        ->name('verify');
});

// Products
Route::group([
    'prefix' => 'products',
    'as' => 'products.',
], function () {
    Route::get('', [ProductController::class, 'newest'])
        ->name('newest');
    Route::get('launched', [ProductController::class, 'launched'])
        ->name('launched');
    Route::view('new', 'products.new')
        ->middleware('auth')
        ->name('new');
});

// Question
Route::group([
    'prefix' => 'question',
    'as' => 'question.',
], function () {
    Route::get('{id}', [QuestionController::class, 'question'])
        ->name('question');
    Route::get('{question}/edit', [QuestionController::class, 'edit'])
        ->middleware('auth')
        ->name('edit');
});

// Questions
Route::group([
    'prefix' => 'questions',
    'as' => 'questions.',
], function () {
    Route::get('', [QuestionController::class, 'newest'])
        ->name('newest');
    Route::get('unanswered', [QuestionController::class, 'unanswered'])
        ->name('unanswered');
    Route::get('popular', [QuestionController::class, 'popular'])
        ->name('popular');
    Route::view('new', 'question.new')
        ->middleware('auth')
        ->name('new');
});

// Milestone
Route::group([
    'prefix' => 'milestones',
    'as' => 'milestones.',
], function () {
    Route::get('', [MilestoneController::class, 'opened'])
        ->name('opened');
    Route::get('closed', [MilestoneController::class, 'closed'])
        ->name('closed');
    Route::view('new', 'milestone.new')
        ->middleware('auth')
        ->name('new');
    Route::get('{milestone}/edit', [MilestoneController::class, 'edit'])
        ->middleware('auth')
        ->name('edit');
    Route::get('{milestone}', [MilestoneController::class, 'milestone'])
        ->name('milestone');
});

// Search
Route::group([
    'prefix' => 'search',
    'as' => 'search.',
], function () {
    Route::get('', [SearchController::class, 'search'])
        ->name('home');
    Route::get('tasks', [SearchController::class, 'tasks'])
        ->name('tasks');
    Route::get('comments', [SearchController::class, 'comments'])
        ->name('comments');
    Route::get('questions', [SearchController::class, 'questions'])
        ->name('questions');
    Route::get('answers', [SearchController::class, 'answers'])
        ->name('answers');
    Route::get('products', [SearchController::class, 'products'])
        ->name('products');
    Route::get('users', [SearchController::class, 'users'])
        ->name('users');
});

// Stafftools
Route::group([
    'prefix' => 'stafftools',
    'as' => 'staff.',
    'middleware' => ['staff_mode'],
], function () {
    Route::view('', 'staff.stats')
        ->middleware('password.confirm')
        ->name('stats');
    Route::view('users', 'staff.users')
        ->middleware('password.confirm')
        ->name('users');
    Route::view('tasks', 'staff.tasks')
        ->middleware('password.confirm')
        ->name('tasks');
    Route::view('activities', 'staff.activities')
        ->middleware('password.confirm')
        ->name('activities');
    Route::view('products', 'staff.products')
        ->middleware('password.confirm')
        ->name('products');
    Route::view('features', 'staff.features')
        ->middleware('password.confirm')
        ->name('features');
    Route::get('system', [StaffController::class, 'system'])
        ->middleware('password.confirm')
        ->name('system');
    Route::view('jobs', 'staff.jobs')
        ->middleware('password.confirm')
        ->name('jobs');
});

// Patron
Route::group([
    'prefix' => 'patron',
    'as' => 'patron.',
], function () {
    Route::view('', 'pages.patron')
        ->name('home');
});

// Paddle Integration
Route::post('paddle/webhook', [PatronController::class, 'handleWebhook'])
    ->name('paddle.webhook');

// Dark mode
Route::get('darkmode', [UserController::class, 'darkMode'])
    ->name('darkmode')
    ->middleware('auth');

// Single Task and comment
Route::group(['prefix' => 'task'], function () {
    Route::get('{id}', [TaskController::class, 'task'])
        ->name('task');
    Route::get('{id}/{comment_id}', [TaskController::class, 'comment'])
        ->name('comment');
});

// Zen mode tasks
Route::view('tasks', 'tasks.tasks')
    ->name('tasks')
    ->middleware('auth');

// Meetups
Route::group([
    'prefix' => 'meetups',
    'as' => 'meetups.',
], function () {
    Route::get('/', [MeetupController::class, 'meetups'])
        ->middleware('staff')
        ->name('home');
    Route::get('/rsvpd', [MeetupController::class, 'rsvpd'])
        ->middleware('staff')
        ->name('rsvpd');
    Route::get('/finished', [MeetupController::class, 'finished'])
        ->middleware('staff')
        ->name('finished');
});

// Pages
Route::get('about', [PagesController::class, 'about'])
    ->name('about');
Route::view('terms', 'pages.terms')
    ->name('terms');
Route::view('privacy', 'pages.privacy')
    ->name('privacy');
Route::view('security', 'pages.security')
    ->name('security');
Route::view('sponsors', 'pages.sponsors')
    ->name('sponsors');
Route::view('contact', 'pages.contact')
    ->name('contact');
Route::view('reputation', 'pages.reputation')
    ->name('reputation')
    ->middleware('auth');
Route::view('open', 'pages.open')
    ->name('open');
Route::view('api', 'pages.api')
    ->middleware('feature:api')
    ->name('api');
Route::get('deals', [PagesController::class, 'deals'])
    ->name('deals');

// Status
Route::group(['prefix' => 'status'], function () {
    Route::get('ping', [StatusController::class, 'ping']);
    Route::get('redis', [StatusController::class, 'redis']);
    Route::get('cache', [StatusController::class, 'redisCache']);
});

// Feed
Route::group([
    'prefix' => 'feed',
    'as' => 'feed.',
], function () {
    Route::get('user/{username}/{page?}', [FeedController::class, 'user'])
        ->name('user');
    Route::get('product/{slug}/{page?}', [FeedController::class, 'product'])
        ->name('product');
});

// Mention
Route::group([
    'prefix' => 'mention',
    'middleware' => ['auth'],
], function () {
    Route::get('users', [UserController::class, 'mention']);
    Route::get('products', [ProductController::class, 'mention']);
});

// Popover
Route::group(['prefix' => 'popover'], function () {
    Route::get('user/{user}', [UserController::class, 'popover']);
    Route::get('product/{product}', [ProductController::class, 'popover']);
    Route::get('milestone/{milestone}', [MilestoneController::class, 'popover']);
});

// Site
Route::group(['prefix' => 'site'], function () {
    Route::view('shortcuts', 'site.shortcuts')
        ->name('shortcuts');
    Route::get('commits-data', [StaffController::class, 'commitsData'])
        ->middleware('staff_mode')
        ->name('commits-data');
    Route::get('ci-data', [StaffController::class, 'ciData'])
        ->middleware('staff_mode')
        ->name('ci-data');
    Route::get('staffbar', [StaffController::class, 'toggle'])
        ->middleware('staff')
        ->name('staffbar');
});

// Sitemaps
Route::get('sitemap_users.txt', [SitemapController::class, 'users']);
Route::get('sitemap_products.txt', [SitemapController::class, 'products']);
Route::get('sitemap_questions.txt', [SitemapController::class, 'questions']);
Route::get('sitemap_tasks.txt', [SitemapController::class, 'tasks']);
Route::get('sitemap_comments.txt', [SitemapController::class, 'comments']);
Route::get('sitemap_milestones.txt', [SitemapController::class, 'milestones']);
Route::view('sitemap_urls.txt', 'seo.sitemap_urls');

// https://web.dev/change-password-url
Route::get('.well-known/change-password', function () {
    return redirect()->route('user.settings.password');
});
