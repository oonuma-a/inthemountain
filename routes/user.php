<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::controller(UserController::class)->group(function () {
    Route::get('/index', 'index')->name('user.index');
    Route::post('/destroy/{id}', 'destroy')->name('user.destroy');
    Route::get('/create', 'create')->name('user.create');
    Route::post('/create', 'store');
    Route::get('/edit/{id}', 'edit')->name('user.edit');
    Route::post('/edit', 'update')->name('user.update');
});