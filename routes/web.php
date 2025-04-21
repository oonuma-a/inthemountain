<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IncludeController;

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
    Route::get('/head', [IncludeController::class, 'head'])->name('include.head');
    Route::get('/sidebar',  [IncludeController::class, 'sidebar'])->name('include.sidebar');
    Route::get('/navigation', [IncludeController::class, 'navigation'])->name('include.navigation');
    Route::get('/footer', [IncludeController::class, 'footer'])->name('include.footer');
});
