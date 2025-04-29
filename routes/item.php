<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\itemController;

Route::controller(itemController::class)->group(function () {
    Route::get('/index', 'index')->name('item.index');
    Route::get('/index/{id}', 'show')->name('item.view');

    Route::get('/create', 'create')->name('item.create');
    Route::post('/store', 'store')->name('item.store');

    Route::get('/edit/{id}', 'edit')->name('item.edit');
    Route::post('/update/{id}', 'update')->name('item.update');

    Route::post('/destroy/{id}', 'destroy')->name('item.destroy');

    // Route::get('/cart', 'cart_index')->name('cart.index');
    // Route::post('/cart', 'cart_add')->name('item.add');
    // Route::post('/cart', 'cart_remove')->name('item.remove');
    Route::get('/cart', 'item_cart_get')->name('cart.index');
    Route::post('/cart', 'item_cart_post')->name('item.cart');
});