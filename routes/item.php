<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\itemController;

Route::controller(itemController::class)->group(function () {
    Route::get('/index', 'index')->name('item.index');
    Route::post('/index', 'item_index_post');

    Route::get('/view', 'item_view_get')->name('item.view');
    Route::post('/view', 'item_view_post');

    Route::get('/create', 'create')->name('item.create');
    Route::post('/create', 'store');

    Route::get('/edit', 'edit')->name('item.edit');
    Route::post('/edit', 'update');

    Route::get('/cart', 'item_cart_get');
    Route::post('/cart', 'item_cart_post')->name('item.cart');
});