<?php

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

Route::get('/api/v2/documentation', 'Web\ApiDocController@v2')->name('v2');
Route::get('/api/v1/documentation', 'Web\ApiDocController@v1')->name('v1');
Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});
Route::get('/{any}', 'Web\AppController@index')->where('any', '.*')->name('home');
