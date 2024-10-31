<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\AuthController;

Route::any('/', function () {
    return 'This is Nectar';
});

Route::fallback(function () {
    return 'Nectar =((';
});

Route::post('/register', [UserAccountController::class, 'register']);

Route::post('/change-password', [UserAccountController::class, 'changePassword']);

Route::get('/zones', [ZoneController::class, 'getZones']);

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function($route) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});
