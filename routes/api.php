<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\ZoneController;

Route::any('/', function () {
    return 'This is Nectar';
});

Route::fallback(function () {
    return 'Nectar =((';
});

Route::post('/register', [UserAccountController::class, 'register']);

Route::post('/login', [UserAccountController::class, 'login']);

Route::post('/change-password', [UserAccountController::class, 'changePassword']);

Route::get('/zones', [ZoneController::class, 'getZones']);
