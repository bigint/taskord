<?php

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

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

Route::get('/', 'HomeController@index')->name('home');
Route::get('suspended', 'UserController@suspended')->name('suspended');

Route::group(['prefix' => '@{username}', 'as' => 'user.'], function () {
    Route::get('', 'UserController@profile')->name('done');
    Route::get('pending', 'UserController@profile')->name('pending');
    Route::get('products', 'UserController@profile')->name('products');
    Route::get('questions', 'UserController@profile')->name('questions');
    Route::get('answers', 'UserController@profile')->name('answers');
    Route::get('following', 'UserController@profile')->name('following');
    Route::get('followers', 'UserController@profile')->name('followers');
});

Route::group(['prefix' => 'settings', 'as' => 'user.settings.', 'middleware' => ['auth']], function () {
    Route::get('', 'UserController@profileSettings')->name('profile');
    Route::get('account', 'UserController@accountSettings')->name('account');
    Route::get('patron', 'UserController@patronSettings')->name('patron');
    Route::get('password', 'UserController@passwordSettings')->name('password');
    Route::get('notifications', 'UserController@notificationsSettings')->name('notifications');
    Route::get('integrations', 'UserController@integrationsSettings')->name('integrations');
    Route::get('export', 'UserController@exportAccount')->name('export');
    Route::get('delete', 'UserController@deleteSettings')->name('delete');
});

Route::group(['prefix' => 'webhook'], function () {
    Route::post('web/{token}', 'WebhookController@web');
    //Route::post('github/{token}', 'WebhookController@github');
});

Route::get('login/{provider}', 'SocialController@redirect');
Route::get('login/{provider}/callback', 'SocialController@Callback');

Route::group(['prefix' => 'product/{slug}', 'as' => 'product.'], function () {
    Route::get('', 'ProductController@profile')->name('done');
    Route::get('pending', 'ProductController@profile')->name('pending');
    Route::get('updates', 'ProductController@profile')->name('updates');
    Route::get('updates/new', 'ProductController@newUpdate')->name('new-update')->middleware('auth');
});

Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
    Route::get('', 'ProductController@newest')->name('newest');
    Route::get('launched', 'ProductController@launched')->name('launched');
});

Route::group(['prefix' => 'questions', 'as' => 'questions.'], function () {
    Route::get('', 'QuestionController@newest')->name('newest');
    Route::get('unanswered', 'QuestionController@unanswered')->name('unanswered');
    Route::get('popular', 'QuestionController@popular')->name('popular');
});

Route::group(['prefix' => 'question', 'as' => 'question.'], function () {
    Route::get('{id}', 'QuestionController@question')->name('question');
});

Route::group(['prefix' => 'notifications', 'as' => 'notifications.', 'middleware' => ['auth']], function () {
    Route::get('', 'NotificationController@unread')->name('unread');
    Route::get('all', 'NotificationController@all')->name('all');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['staff']], function () {
    Route::get('', 'AdminController@admin')->name('stats');
    Route::get('users', 'AdminController@users')->name('users');
    Route::get('adminbar', 'AdminController@toggle')->name('adminbar');
});

Route::group(['prefix' => 'patron', 'as' => 'patron.'], function () {
    Route::get('', 'PatronController@patron')->name('home');
});

// Toggles
Route::get('darkmode', 'UserController@darkMode')->name('darkmode')->middleware('patron');

Route::get('task/{id}', 'TaskController@task')->name('task');

Route::get('tasks', 'TaskController@tasks')->name('tasks')->middleware('auth');

Route::get('streaks/{username}', 'StatsController@streaks')->name('streak');

Route::group(['prefix' => 'search', 'as' => 'search.'], function () {
    Route::get('', 'SearchController@search')->name('home');
    Route::get('tasks', 'SearchController@tasks')->name('tasks');
    Route::get('comments', 'SearchController@comments')->name('comments');
    Route::get('questions', 'SearchController@questions')->name('questions');
    Route::get('answers', 'SearchController@answers')->name('answers');
    Route::get('users', 'SearchController@users')->name('users');
});

// Pages
Route::get('about', 'PagesController@about')->name('about');
Route::get('reputation', 'PagesController@reputation')->name('reputation');
Route::get('terms', 'PagesController@terms')->name('terms');
Route::get('privacy', 'PagesController@privacy')->name('privacy');
Route::get('security', 'PagesController@security')->name('security');
Route::get('open', 'PagesController@open')->name('open');

Route::post('paddle/webhook', 'PatronController@handleWebhook')->name('paddle.webhook');
