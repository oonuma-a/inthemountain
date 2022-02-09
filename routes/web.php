<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IncludeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\itemController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('shop/index');
});
Route::prefix('include')->group(function(){
    Route::match(['get','post'],'/head', [IncludeController::class, 'head'])->name('include.head');
    Route::match(['get','post'],'/sidebar',  [IncludeController::class, 'sidebar'])->name('include.sidebar');
    Route::match(['get','post'],'/navigation', [IncludeController::class, 'navigation'])->name('include.navigation');
    Route::match(['get','post'],'/footer', [IncludeController::class, 'footer'])->name('include.footer');
});

Route::prefix('shop')->group(function(){
    Route::get('/index',  [ShopController::class, 'shop_index_get'])->name('shop.index');
    Route::post('/index',  [ShopController::class, 'shop_index_post']);
    Route::get('/create',  [ShopController::class, 'shop_create_get'])->name('shop.create');
    Route::post('/create',  [ShopController::class, 'shop_create_post']);
    Route::get('/edit',  [ShopController::class, 'shop_edit_get'])->name('shop.edit');
    Route::post('/edit',  [ShopController::class, 'shop_edit_post']);
});

Route::prefix('item')->group(function(){
    Route::get('/index',  [itemController::class, 'item_index_get'])->name('item.index');
    Route::post('/index',  [itemController::class, 'item_index_post']);
    Route::get('/create',  [itemController::class, 'item_create_get'])->name('item.create');
    Route::post('/create',  [itemController::class, 'item_create_post']);
    Route::get('/edit',  [itemController::class, 'item_edit_get'])->name('item.edit');
    Route::post('/edit',  [itemController::class, 'item_edit_post']);
});
Route::prefix('user')->group(function(){
    Route::get('/index',  [userController::class, 'user_index_get'])->name('user.index');
    Route::post('/index',  [userController::class, 'user_index_post']);
    Route::get('/create',  [userController::class, 'user_create_get'])->name('user.create');
    Route::post('/create',  [userController::class, 'user_create_post']);
    Route::get('/edit',  [userController::class, 'user_edit_get'])->name('user.edit');
    Route::post('/edit',  [userController::class, 'user_edit_post']);
});
