<?php

use App\Http\Controllers\BannerController;
use App\Http\Middleware\ApiAuthMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductCategoriesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserDataController;

// Public ---------------------------------------------------------------------------

Route::any('/', function () {
    return __(key: 'messages.app_name');
});

Route::fallback(function () {
    return __(key: 'messages.fallback_route');
});

Route::post('/register', [UserAccountController::class, 'register']);

Route::get('/zones', ZoneController::class);

Route::get('/products', ProductController::class);

Route::get('/banners', BannerController::class);

Route::get('/product-categories', ProductCategoriesController::class);

Route::get('/product-detail/{products_id}', [ProductController::class, 'getProductById']);

Route::get('/products/search', [ProductController::class, 'search']);

// End public api -----------------------------------------------------------------------

// Authentication -----------------------------------------------------------------------

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/me', [AuthController::class, 'me']);
});

// End authentication --------------------------------------------------------------------


// Authorization -------------------------------------------------------------------------

Route::middleware([ApiAuthMiddleware::class])->group(function () {
    Route::get('/user-location', [UserDataController::class, 'getLocation']);
    Route::get('/favorite-products', [ProductController::class, 'getFavoriteProducts']);
});

// ---------------------------------------------------------------------------------------
