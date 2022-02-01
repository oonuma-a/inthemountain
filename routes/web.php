<?php

use Illuminate\Support\Facades\Route;

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
    return view('/shop/index');
});
Route::prefix('include')->group(function(){
    Route::match(['get','post'],'/include/head','IncludeController@head')->name('include.head');
    Route::match(['get','post'],'/include/sidebar', 'IncludeController@sidebar')->name('include.sidebar');
    Route::match(['get','post'],'/include/navigation','IncludeController@navigation')->name('include.navigation');
    Route::match(['get','post'],'/include/footer','IncludeController@footer')->name('include.footer');
});

Route::prefix('shop')->group(function(){
    Route::get('/index', 'ShopController@shop_index_get')->name('shop.index');
    Route::post('/index', 'ShopController@shop_index_post');
});
