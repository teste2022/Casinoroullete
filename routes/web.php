<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');

Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/', 'SiteController@roulette');
Route::get('/faq', 'SiteController@faq');
Route::get('/maintenance', 'SiteController@maintenance');
Route::get('/games', 'SiteController@games');
Route::get('/giveaway', 'SiteController@giveaway');
Route::get('/coinflip', 'SiteController@coinflip');
Route::get('/jackpot', 'SiteController@jackpot');
Route::get('/roulette', 'SiteController@roulette');
Route::get('/terms', 'SiteController@terms');
Route::get('/crash', 'SiteController@crash');
Route::get('/support', 'SiteController@support');
Route::get('/dice', 'SiteController@dice');
Route::get('/pf', 'SiteController@pf');
Route::get('/crashhistory', 'SiteController@crashhistory');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/user/deposit', 'SiteController@deposit');
    Route::get('/user/withdraw', 'SiteController@withdraw');
    Route::get('/user/profile', 'SiteController@profile');
    Route::get('/user/referrals', 'SiteController@referrals');
});

Route::group(['middleware' => 'admin'], function () {
    Route::get('/admin/profile', 'AdminController@profile');
    Route::get('/admin/api/transaction-history', 'ApiController@admin_transaction_history');
});

Route::get('api/transaction-history', 'ApiController@transaction_history');
Route::get('api/site-inventory', 'ApiController@site_inventory');
Route::get('api/free-coins', 'ApiController@free_coins');
Route::get('api/group-join', 'ApiController@group_join');
Route::post('api/affiliates-collect', 'ApiController@affiliates_collect');

View::composer('errors::404', 'App\Http\Controllers\ErrorController@error404');

Route::get('/accesspiroca', function() {
    $response = new Illuminate\Http\Response('Cookie installed');
    $response->withCookie(cookie()->forever('secret-cookie', 'AbcEfsdgdfgfdghfd'));
    return $response;
});
