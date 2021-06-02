<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
Route::get('/products', 'App\Http\Controllers\ProductsController@index')->name('shop');
Route::get('/products/{slug}', 'App\Http\Controllers\ProductsController@details')->where('slug', '^[a-z][-\.a-z0-9]*')->name('detail');
//Route::get('/search', 'App\Http\Controllers\ProductsController@search')->name('products.search');
//auth
Route::get('/   ', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::view('/index', 'layouts.index')->name('index');

//dashboard
Route::view('/dashboard', 'dashboard.index')->name('dashboard');
Route::resource('/dashboard/categories', App\Http\Controllers\CategoriesController::class);
Route::view('/dashboard/products', 'dashboard.products')->name('products');


Route::middleware(['auth'])->group(function () {

    //cart
    Route::post('/cart/add', 'App\Http\Controllers\CartController@store')->name('cart.store');
    Route::get('/cart', 'App\Http\Controllers\CartController@index')->name('cart');
    Route::patch('/cart/{rowId}', 'App\Http\Controllers\CartController@update')->name('cart.update');
    Route::delete('/cart/{rowId}', 'App\Http\Controllers\CartController@destroy')->name('cart.delete');
    Route::post('/coupon', 'App\Http\Controllers\CouponsController@store')->name('cart.store.coupon');
    Route::delete('/coupon', 'App\Http\Controllers\CouponsController@destroy')->name('cart.destroy.coupon');


    //checkout
    Route::get('/checkout', 'App\Http\Controllers\CheckoutController@index')->name('checkout');
    Route::post('/checkout', 'App\Http\Controllers\CheckoutController@store')->name('checkout.store');
    Route::get('/thankyou', 'App\Http\Controllers\CheckoutController@thankyou');

    //orders
    Route::get('/myorders', function () {
        return view('orders');
    })->name('myorders');
});

//voyager
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
