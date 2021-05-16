<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;

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
Auth::routes();
Route::get('/products',[ProductsController::class,'index']);

Route::get('/about', 'App\Http\Controllers\ProductsController@about');

Route::get('/products/{name}','App\Http\Controllers\ProductsController@details')->where('name','[a-zA-Z]+');
//auth
Route::get('/   ', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::view('/index', 'boutique.index')->name('index');
Route::view('/shop', 'boutique.shop')->name('shop');
Route::view('/detail', 'boutique.detail')->name('detail');
Route::view('/cart', 'boutique.cart')->name('cart');
Route::view('/checkout', 'boutique.checkout')->name('checkout');


