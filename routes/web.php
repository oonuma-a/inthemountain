<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IncludeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\itemController;
use App\Http\Controllers\UserController;

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

Route::prefix('auth')->group(function(){
    Route::get('/index',  [AuthController::class, 'auth_index_get'])->name('auth.index');
    Route::post('/index',  [AuthController::class, 'auth_index_post']);
});

Route::prefix('include')->group(function(){
    Route::get('/head', [IncludeController::class, 'head'])->name('include.head');
    Route::get('/sidebar',  [IncludeController::class, 'sidebar'])->name('include.sidebar');
    Route::get('/navigation', [IncludeController::class, 'navigation'])->name('include.navigation');
    Route::get('/footer', [IncludeController::class, 'footer'])->name('include.footer');
});

Route::prefix('shop')->group(function(){
    Route::get('/index',  [ShopController::class, 'shop_index_get'])->name('shop.index');
    Route::post('/index',  [ShopController::class, 'shop_index_post']);
    Route::get('/detail',  [ShopController::class, 'shop_detail_get'])->name('shop.detail');
});

Route::prefix('item')->group(function(){
    Route::get('/index',  [itemController::class, 'item_index_get'])->name('item.index');
    Route::post('/index',  [itemController::class, 'item_index_post']);
    Route::get('/view',  [itemController::class, 'item_view_get'])->name('item.view');
    Route::post('/view',  [itemController::class, 'item_view_post']);
    Route::get('/create',  [itemController::class, 'item_create_get'])->name('item.create');
    Route::post('/create',  [itemController::class, 'item_create_post']);
    Route::get('/edit',  [itemController::class, 'item_edit_get'])->name('item.edit');
    Route::post('/edit',  [itemController::class, 'item_edit_post']);
    Route::get('/cart',  [itemController::class, 'item_cart_get']);
    Route::post('/cart',  [itemController::class, 'item_cart_post'])->name('item.cart');
});
Route::prefix('user')->group(function(){
    Route::get('/index',  [UserController::class, 'user_index_get'])->name('user.index');
    Route::post('/index',  [UserController::class, 'user_index_post']);
    Route::get('/create',  [UserController::class, 'user_create_get'])->name('user.create');
    Route::post('/create',  [UserController::class, 'user_create_post']);
    Route::get('/edit',  [UserController::class, 'user_edit_get'])->name('user.edit');
    Route::post('/edit',  [UserController::class, 'user_edit_post']);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
