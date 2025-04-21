<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;

Route::controller(ShopController::class)->group(function () {
    Route::get('/index', 'index')->name('shop.index');
    Route::post('/index', 'shop_index_post');
    Route::get('/detail', 'show')->name('shop.detail');
});