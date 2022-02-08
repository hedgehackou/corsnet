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

Route::get('/', 'App\Modules\FrontController\Controllers\FrontController@mainPage');
Route::get('/{page:slug}', 'App\Modules\FrontController\Controllers\FrontController@regularPage');

Route::get('/{any}', 'App\Modules\FrontController\Controllers\FrontController@index')
    ->where('any', '.*')
    ->name('spa');

Route::get('reset-password/{token}')->name('password.reset');
Route::get('accept-invite/{token}')->name('invite.accept');
Route::get('login')->name('email.verify');
