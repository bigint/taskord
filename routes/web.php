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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::group(['prefix' => '@{username}', 'as' => 'user.'], function () {
    Route::get('', 'UserController@done')->name('done');
    Route::get('pending', 'UserController@pending')->name('pending');
    Route::get('products', 'UserController@products')->name('products');
    Route::get('questions', 'UserController@questions')->name('questions');
    Route::get('answers', 'UserController@answers')->name('answers');
    Route::get('following', 'UserController@following')->name('following');
    Route::get('followers', 'UserController@followers')->name('followers');
});

Route::group(['prefix' => 'settings', 'as' => 'user.settings.', 'middleware' => ['auth', 'password.confirm']], function () {
    Route::get('', 'UserController@profileSettings')->name('profile');
    Route::get('account', 'UserController@accountSettings')->name('account');
    Route::get('password', 'UserController@passwordSettings')->name('password');
    Route::get('notifications', 'UserController@notificationsSettings')->name('notifications');
    Route::get('delete', 'UserController@deleteSettings')->name('delete');
});

Route::get('login/{provider}', 'SocialController@redirect');
Route::get('login/{provider}/callback', 'SocialController@Callback');

Route::group(['prefix' => 'product/{slug}', 'as' => 'product.'], function () {
    Route::get('', 'ProductController@done')->name('done');
    Route::get('pending', 'ProductController@pending')->name('pending');
    Route::get('updates', 'ProductController@updates')->name('updates');
    Route::get('updates/new', 'ProductController@newUpdate')->name('new')->middleware('auth');
    Route::get('edit', 'ProductController@edit')->name('edit')->middleware('auth');
});

Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
    Route::get('', 'ProductController@newest')->name('newest');
    Route::get('launched', 'ProductController@launched')->name('launched');
    Route::get('new', 'ProductController@new')->name('new')->middleware('auth');
});

Route::group(['prefix' => 'questions', 'as' => 'questions.'], function () {
    Route::get('', 'QuestionController@newest')->name('newest');
    Route::get('unanswered', 'QuestionController@unanswered')->name('unanswered');
    Route::get('popular', 'QuestionController@popular')->name('popular');
    Route::get('new', 'QuestionController@new')->name('new')->middleware('auth');
});

Route::group(['prefix' => 'question', 'as' => 'question.'], function () {
    Route::get('{id}', 'QuestionController@question')->name('question');
    Route::get('edit/{id}', 'QuestionController@edit')->name('edit')->middleware('auth');
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

// Toggles
Route::get('darkmode', 'UserController@darkMode')->name('darkmode')->middleware('patron');

Route::get('task/{id}', 'TaskController@task')->name('task');

Route::get('tasks', 'TaskController@tasks')->name('tasks')->middleware('auth');

Route::get('patron', 'PatronController@patron')->name('patron');

Route::personalDataExports('personal-data-exports');

Route::get('streaks/{username}', 'StatsController@streaks')->name('streak');
