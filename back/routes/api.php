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

Route::group([
    'middleware' => ['auth:sanctum'],
], function ($router) {
    Route::post('auth/fetch-profile', 'App\Modules\Auth\Controllers\AuthController@fetchProfile');
    //Invites
    Route::post('invites', 'App\Modules\Invite\Controllers\InviteController@createInvite');
    Route::post('invites/accept', 'App\Modules\Invite\Controllers\InviteController@acceptInvite');
    Route::get('invites', 'App\Modules\Invite\Controllers\InviteController@getInviteList');
    Route::get('invites/{token}', 'App\Modules\Invite\Controllers\InviteController@getInviteInfo');
    Route::delete('invites/{inviteId}', 'App\Modules\Invite\Controllers\InviteController@deleteInvite');
    //Base stations
    Route::post('base-stations', 'App\Modules\BaseStations\Controllers\BaseStationsController@createBaseStation');
    Route::put('base-stations/{baseStationId}', 'App\Modules\BaseStations\Controllers\BaseStationsController@updateBaseStation');
    Route::get('base-stations', 'App\Modules\BaseStations\Controllers\BaseStationsController@getBaseStationList');
    Route::get('base-stations/{baseStationId}', 'App\Modules\BaseStations\Controllers\BaseStationsController@getBaseStation');
    Route::delete('base-stations/{baseStationId}', 'App\Modules\BaseStations\Controllers\BaseStationsController@deleteBaseStation');
    //Receivers
    Route::post('base-stations/{baseStationId}/receivers', 'App\Modules\BaseStations\Controllers\ReceiverController@createReceiver');
    Route::get('base-stations/{baseStationId}/receivers', 'App\Modules\BaseStations\Controllers\ReceiverController@getReceiverList');
    Route::get('base-stations/{baseStationId}/receivers/satellite-list', 'App\Modules\BaseStations\Controllers\ReceiverController@getSatelliteSystemList');
    Route::put('base-stations/{baseStationId}/receivers/{receiverId}', 'App\Modules\BaseStations\Controllers\ReceiverController@updateReceiver');
    Route::get('base-stations/{baseStationId}/receivers/{receiverId}', 'App\Modules\BaseStations\Controllers\ReceiverController@getReceiver');
    Route::delete('base-stations/{baseStationId}/receivers/{receiverId}', 'App\Modules\BaseStations\Controllers\ReceiverController@deleteReceiver');
    //Antennas
    Route::post('base-stations/{baseStationId}/antennas', 'App\Modules\BaseStations\Controllers\AntennaController@createAntenna');
    Route::get('base-stations/{baseStationId}/antennas', 'App\Modules\BaseStations\Controllers\AntennaController@getAntennaList');
    Route::put('base-stations/{baseStationId}/antennas/{antennaId}', 'App\Modules\BaseStations\Controllers\AntennaController@updateAntenna');
    Route::get('base-stations/{baseStationId}/antennas/{antennaId}', 'App\Modules\BaseStations\Controllers\AntennaController@getAntenna');
    Route::delete('base-stations/{baseStationId}/antennas/{antennaId}', 'App\Modules\BaseStations\Controllers\AntennaController@deleteAntenna');
    //Mount points
    Route::post('base-stations/{baseStationId}/mount-points', 'App\Modules\BaseStations\Controllers\MountPointsController@createMountPoint');
    Route::get('base-stations/{baseStationId}/mount-points', 'App\Modules\BaseStations\Controllers\MountPointsController@getMountPointList');
    Route::put('base-stations/{baseStationId}/mount-points/{mountPointId}', 'App\Modules\BaseStations\Controllers\MountPointsController@updateMountPoint');
    Route::get('base-stations/{baseStationId}/mount-points/{mountPointId}', 'App\Modules\BaseStations\Controllers\MountPointsController@getMountPoint');
    Route::delete('base-stations/{baseStationId}/mount-points/{mountPointId}', 'App\Modules\BaseStations\Controllers\MountPointsController@deleteMountPoint');

    //Users
    Route::get('users', 'App\Modules\Users\Controllers\UsersController@getUserList');
    //Clients
    Route::post('users/{userId}/clients', 'App\Modules\Users\Controllers\ClientsController@createClient');
    Route::get('users/{userId}/clients', 'App\Modules\Users\Controllers\ClientsController@getClientList');
    Route::get('users/{userId}/clients/{clientId}', 'App\Modules\Users\Controllers\ClientsController@getClient');
    Route::put('users/{userId}/clients/{clientId}', 'App\Modules\Users\Controllers\ClientsController@updateClient');
    Route::delete('users/{userId}/clients/{clientId}', 'App\Modules\Users\Controllers\ClientsController@deleteClient');
    //Casters
    Route::post('casters', 'App\Modules\Casters\Controllers\CasterController@createCaster');
    Route::get('casters', 'App\Modules\Casters\Controllers\CasterController@getCasterList');
    Route::get('casters/{casterId}/events', 'App\Modules\Casters\Controllers\CasterController@getEventList');
    Route::get('casters/{casterId}', 'App\Modules\Casters\Controllers\CasterController@getCaster');
    Route::put('casters/{casterId}', 'App\Modules\Casters\Controllers\CasterController@updateCaster');
    Route::post('casters/{casterId}/restart', 'App\Modules\Casters\Controllers\CasterController@restartCaster');
    Route::delete('casters/{casterId}', 'App\Modules\Casters\Controllers\CasterController@deleteCaster');
    //Countries
    Route::get('countries', 'App\Modules\Countries\Controllers\CountryController@getCountries');
    //Settings
    Route::get('settings', 'App\Modules\Settings\Controllers\SettingsController@getSettings');
    Route::put('settings', 'App\Modules\Settings\Controllers\SettingsController@updateSettings');
});

Route::group([
    'middleware' => ['cors'],
], function ($router) {
    //Auth
    Route::post('auth/login', 'App\Modules\Auth\Controllers\AuthController@login');
    Route::post('auth/send-reset-link', 'App\Modules\Auth\Controllers\AuthController@sendResetLink');
    Route::post('auth/reset-password', 'App\Modules\Auth\Controllers\AuthController@resetPassword');
    //Install
    Route::post('install/connect-to-database', 'App\Modules\Installation\Controllers\InstallationController@connectToDatabase');
    Route::post('install/setup-smtp', 'App\Modules\Installation\Controllers\InstallationController@setupSmtp');
    Route::post('install/add-settings', 'App\Modules\Installation\Controllers\InstallationController@addSettings');
    Route::post('install/installation', 'App\Modules\Installation\Controllers\InstallationController@installation');
    Route::get('install/is-project-installed', 'App\Modules\Installation\Controllers\InstallationController@isProjectInstalled');
    Route::get('install/get-project-settings', 'App\Modules\Installation\Controllers\InstallationController@getProjectSettings');
    //Casters
    Route::post('casters/{casterId}/events', 'App\Modules\Casters\Controllers\CasterController@handleCasterEvents');
});

