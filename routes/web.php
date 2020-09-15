<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PatronController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SitemapController;

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
Route::get('login/{provider}/callback', [SocialController::class, 'Callback']);

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// User
Route::group(['prefix' => '@{username}', 'as' => 'user.'], function () {
    Route::get('', [UserController::class, 'profile'])->name('done');
    Route::get('pending', [UserController::class, 'profile'])->name('pending');
    Route::get('products', [UserController::class, 'profile'])->name('products');
    Route::get('questions', [UserController::class, 'profile'])->name('questions');
    Route::get('answers', [UserController::class, 'profile'])->name('answers');
    Route::get('following', [UserController::class, 'profile'])->name('following');
    Route::get('followers', [UserController::class, 'profile'])->name('followers');
});

// Settings
Route::group(['prefix' => 'settings', 'as' => 'user.settings.', 'middleware' => ['auth']], function () {
    Route::get('', [UserController::class, 'profileSettings'])->name('profile');
    Route::get('account', [UserController::class, 'accountSettings'])->name('account');
    Route::get('patron', [UserController::class, 'patronSettings'])->name('patron');
    Route::get('password', [UserController::class, 'passwordSettings'])->name('password');
    Route::get('notifications', [UserController::class, 'notificationsSettings'])->name('notifications');
    Route::get('integrations', [UserController::class, 'integrationsSettings'])->name('integrations');
    Route::get('export', [UserController::class, 'exportAccount'])->name('export');
    Route::get('delete', [UserController::class, 'deleteSettings'])->name('delete');
});

// Notifications
Route::group(['prefix' => 'notifications', 'as' => 'notifications.', 'middleware' => ['auth']], function () {
    Route::view('', 'notifications.unread')->name('unread');
    Route::view('all', 'notifications.all')->name('all');
});

// Suspended
Route::get('suspended', [UserController::class, 'suspended'])->name('suspended');

// Avatar
Route::get('avatar/{username}.png', [UserController::class, 'avatar'])->name('avatar');

// Webhooks
Route::group(['prefix' => 'webhook'], function () {
    Route::post('web/{token}', [WebhookController::class, 'web']);
});

// Product
Route::group(['prefix' => 'product/{slug}', 'as' => 'product.'], function () {
    Route::get('', [ProductController::class, 'profile'])->name('done');
    Route::get('pending', [ProductController::class, 'profile'])->name('pending');
    Route::get('updates', [ProductController::class, 'profile'])->name('updates');
});

// Products
Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
    Route::get('', [ProductController::class, 'newest'])->name('newest');
    Route::get('launched', [ProductController::class, 'launched'])->name('launched');
});

// Question
Route::group(['prefix' => 'question', 'as' => 'question.'], function () {
    Route::get('{id}', [QuestionController::class, 'question'])->name('question');
});

// Questions
Route::group(['prefix' => 'questions', 'as' => 'questions.'], function () {
    Route::get('', [QuestionController::class, 'newest'])->name('newest');
    Route::get('unanswered', [QuestionController::class, 'unanswered'])->name('unanswered');
    Route::get('popular', [QuestionController::class, 'popular'])->name('popular');
});

// Search
Route::group(['prefix' => 'search', 'as' => 'search.'], function () {
    Route::get('', [SearchController::class, 'search'])->name('home');
    Route::get('tasks', [SearchController::class, 'tasks'])->name('tasks');
    Route::get('comments', [SearchController::class, 'comments'])->name('comments');
    Route::get('questions', [SearchController::class, 'questions'])->name('questions');
    Route::get('answers', [SearchController::class, 'answers'])->name('answers');
    Route::get('products', [SearchController::class, 'products'])->name('products');
    Route::get('users', [SearchController::class, 'users'])->name('users');
});

// Admin
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['staff']], function () {
    Route::get('users', [AdminController::class, 'users'])->name('users');
    Route::get('adminbar', [AdminController::class, 'toggle'])->name('adminbar');
});

// Patron
Route::group(['prefix' => 'patron', 'as' => 'patron.'], function () {
    Route::get('', [PatronController::class, 'patron'])->name('home');
});

// Paddle Integration
Route::post('paddle/webhook', [PatronController::class, 'handleWebhook'])->name('paddle.webhook');

// Dark mode
Route::get('darkmode', [UserController::class, 'darkMode'])->name('darkmode')->middleware('patron');

// Single Task
Route::get('task/{id}', [TaskController::class, 'task'])->name('task');

// Zen mode tasks
Route::get('tasks', [TaskController::class, 'tasks'])->name('tasks')->middleware('auth');

// Pages
Route::view('about', 'pages.about')->name('about');
Route::view('reputation', 'pages.reputation')->name('reputation');
Route::view('terms', 'pages.terms')->name('terms');
Route::view('privacy', 'pages.privacy')->name('privacy');
Route::view('security', 'pages.security')->name('security');
Route::get('open', 'PagesController@open')->name('open');
Route::get('deals', 'PagesController@deals')->name('deals');

// https://web.dev/change-password-url
Route::get('.well-known/change-password', function () {
    return redirect()->route('user.settings.password');
});

// Sitemaps
Route::get('sitemap_users.txt', [SitemapController::class, 'users']);
Route::get('sitemap_products.txt', [SitemapController::class, 'products']);
Route::get('sitemap_questions.txt', [SitemapController::class, 'questions']);
