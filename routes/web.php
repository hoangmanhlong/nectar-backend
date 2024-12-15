<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Cms\HomeController;

Route::get('/', HomeController::class);

Route::fallback(function () {
    return view('welcome');
});
