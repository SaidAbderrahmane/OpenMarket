<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Models\OrderLine;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use TCG\Voyager\Facades\Voyager;

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

//review
Route::post('/submit-review', 'App\Http\Controllers\ReviewsController@store')->name('review.store');
Route::patch('/update-review/{id}', 'App\Http\Controllers\ReviewsController@update')->name('review.update');
Route::delete('/destroy-review/{id}', 'App\Http\Controllers\ReviewsController@destroy')->name('review.destroy');

//cart
Route::post('/cart/add', 'App\Http\Controllers\CartController@store')->name('cart.store');
Route::get('/cart', 'App\Http\Controllers\CartController@index')->name('cart');
Route::patch('/cart/{rowId}', 'App\Http\Controllers\CartController@update')->name('cart.update');
Route::delete('/cart/{rowId}', 'App\Http\Controllers\CartController@destroy')->name('cart.delete');
Route::post('/coupon', 'App\Http\Controllers\CouponsController@store')->name('coupon.store');
Route::delete('/coupon', 'App\Http\Controllers\CouponsController@destroy')->name('coupon.destroy');


Route::middleware(['auth'])->group(function () {


    //wishlist
    Route::post('/wishlist/add', 'App\Http\Controllers\WishlistController@store')->name('wishlist.store');
    Route::get('/wishlist', 'App\Http\Controllers\WishlistController@index')->name('wishlist');
    Route::delete('/wishlist/{rowId}', 'App\Http\Controllers\WishlistController@destroy')->name('wishlist.delete');


    //checkout
    Route::get('/checkout', 'App\Http\Controllers\CheckoutController@index')->name('checkout');
    Route::post('/checkout', 'App\Http\Controllers\CheckoutController@store')->name('checkout.store');
    Route::get('/cash', 'App\Http\Controllers\CheckoutController@cash')->name('checkout.cash');
    Route::post('/cash', 'App\Http\Controllers\CheckoutController@cash_store')->name('checkout.cash.store');
    Route::get('/thankyou', 'App\Http\Controllers\CheckoutController@thankyou');

    //orders
    Route::get('/my-orders', function () {
        return view('orders');
    })->name('myorders');

    //profile
    Route::get('/my-profile', 'App\Http\Controllers\UsersController@edit')->name('users.edit');
    Route::patch('/my-profile', 'App\Http\Controllers\UsersController@update')->name('users.update');


    //store_owner routes 
    Route::group(['middleware' => 'role:Store owner'], function () {
        Route::get('/store-owner', 'App\Http\Controllers\StoreOwnerController@index')->name('store_owner.index');

        Route::get('/store-owner/products', 'App\Http\Controllers\StoreOwnerController@products')->name('store_owner.products');

        Route::get('/store-owner/products/add', 'App\Http\Controllers\StoreOwnerController@add_product')->name('store_owner.products.add');
        Route::get('/store-owner/products/{id}', 'App\Http\Controllers\StoreOwnerController@view_product')->name('store_owner.products.view');
        Route::get('/store-owner/products/{id}/edit', 'App\Http\Controllers\StoreOwnerController@edit_product')->name('store_owner.products.edit');
        Route::post('/store-owner/prodcuts/store', 'App\Http\Controllers\ProductsController@store')->name('product.store');
        Route::patch('/store-owner/products/{id}/edit', 'App\Http\Controllers\ProductsController@update')->name('product.update');
        Route::delete('/store-owner/products/{id}/remove', 'App\Http\Controllers\ProductsController@destroy')->name('product.destroy');


        Route::get('/store-owner/stores', 'App\Http\Controllers\StoreOwnerController@stores')->name('store_owner.stores');

        Route::get('/store-owner/stores/add',  'App\Http\Controllers\StoreOwnerController@add_store')->name('store_owner.stores.add');
        Route::get('/store-owner/stores/{id}', 'App\Http\Controllers\StoreOwnerController@view_store')->name('store_owner.stores.view');
        Route::get('/store-owner/stores/{id}/edit', 'App\Http\Controllers\StoreOwnerController@edit_store')->name('store_owner.stores.edit');
        Route::post('/store-owner/stores/store', 'App\Http\Controllers\StoresController@store')->name('store.store');
        Route::patch('/store-owner/stores/{id}/edit', 'App\Http\Controllers\StoresController@update')->name('store.update');
        Route::delete('/store-owner/stores/{id}/remove', 'App\Http\Controllers\StoresController@destroy')->name('store.destroy');

        Route::get('/store-owner/orders', 'App\Http\Controllers\StoreOwnerController@orders')->name('store_owner.orders');
    });
});

//voyager
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

//stores
Route::get('/stores', 'App\Http\Controllers\StoresController@index')->name('stores.index');
Route::get('/stores/{id}', 'App\Http\Controllers\StoresController@show')->name('stores.visit');

//test
Route::any('/test', function () {

    $top_10_products_by_amount = DB::table("order_lines")
        ->join("products", "products.id", "=", "order_lines.product_id")
        ->select("products.title", DB::raw('sum(order_lines.price)/100 as amount'))
        ->limit(10)
        ->orderBy("amount", "desc")
        ->groupBy("products.title")
        ->get();
    return view('test')->with(['top_10_products_by_amount' => $top_10_products_by_amount->toArray()]);
});
