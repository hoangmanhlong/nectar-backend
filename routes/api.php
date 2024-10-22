<?php

use Illuminate\Support\Facades\Route;

Route::any('/', function() {
    return 'This is Nectar';
});

Route::fallback(function () {
    return 'Nectar =((';
});