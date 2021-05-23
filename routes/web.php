<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;

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

//products
Route::get('/products','App\Http\Controllers\ProductsController@index')->name('shop');
Route::get('/products/{slug}','App\Http\Controllers\ProductsController@details')->where('slug','^[a-z][-\.a-z0-9]*')->name('detail');
//auth
Route::get('/   ', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::view('/index', 'layouts.index')->name('index');

//dashboard
Route::view('/dashboard', 'dashboard.index')->name('dashboard');
Route::resource('/dashboard/categories',App\Http\Controllers\CategoriesController::class);
Route::view('/dashboard/products', 'dashboard.products')->name('products');

//cart
Route::post('/cart/add','App\Http\Controllers\CartController@store')->name('cart.store');
Route::get('/emptycart', function () {
    Cart::destroy();
});
Route::get('/cart', 'App\Http\Controllers\CartController@index')->name('cart');
Route::delete('/cart/{rowId}', 'App\Http\Controllers\CartController@destroy')->name('cart.delete');

//checkout
Route::get('/checkout', 'App\Http\Controllers\CheckoutController@index')->name('checkout');
