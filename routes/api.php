<?php

use App\Http\Controllers\BannerController;
use App\Http\Middleware\ApiAuthMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\CheckoutController;
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

Route::get('/product/category/{category_id}', [ProductController::class, 'getProductsByCategory']);

// End public api -----------------------------------------------------------------------

// Authentication -----------------------------------------------------------------------

Route::middleware('api')->prefix('auth')->group(function () {
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
    Route::put('/favorite-product/{product_id}', [ProductController::class, 'favoriteProduct']);
    Route::post('/product/rating', [ProductController::class, 'ratingProduct']);
    Route::get('/profile', [UserDataController::class, 'getProfile']);
    Route::post('/checkout', [CheckoutController::class, 'checkout']);
    Route::get('/total-product-in-cart', [BasketController::class, 'getNumberOfProductInBasket']);

    Route::prefix('basket')->group(function () {
        Route::get('/', BasketController::class);
        Route::post('/', [BasketController::class, 'add']);
        Route::patch('/', [BasketController::class, 'update']);
        Route::delete('/', [BasketController::class, 'delete']);
    });
});

// ---------------------------------------------------------------------------------------
