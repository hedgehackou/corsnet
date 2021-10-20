<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([
    'middleware' => ['cors'],
], function ($router) {
    Route::post('install/connect-to-database', 'App\Modules\Installation\Controllers\InstallationController@connectToDatabase');
    Route::post('install/setup-smtp', 'App\Modules\Installation\Controllers\InstallationController@setupSmtp');
    Route::post('install/add-settings', 'App\Modules\Installation\Controllers\InstallationController@addSettings');
    Route::post('install/installation', 'App\Modules\Installation\Controllers\InstallationController@installation');
    Route::get('install/is-project-installed', 'App\Modules\Installation\Controllers\InstallationController@isProjectInstalled');
});

