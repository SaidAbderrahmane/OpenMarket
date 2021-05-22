<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Models\Product;

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
//product routes
Route::get('/products','App\Http\Controllers\ProductsController@index')->name('shop');
Route::get('/products/{slug}','App\Http\Controllers\ProductsController@details')->where('slug','^[a-z][-\.a-z0-9]*');
//auth
Route::get('/   ', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::view('/index', 'boutique.index')->name('index');
Route::view('/detail', 'boutique.detail')->name('detail');
Route::view('/cart', 'boutique.cart')->name('cart');
Route::view('/checkout', 'boutique.checkout')->name('checkout');
Route::view('/dashboard', 'dashboard.index')->name('dashboard');
Route::resource('/dashboard/categories',App\Http\Controllers\CategoriesController::class);
Route::view('/dashboard/products', 'dashboard.products')->name('products');
Route::view('/show', 'boutique.show');
