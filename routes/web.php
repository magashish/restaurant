<?php

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
    return View::make('pages.home');
})->name('pages.home');

Route::get('/about', function(){
   return View::make('pages.about');
})->name('about');

Route::get('/restaurant', function(){
   return View::make('pages.restaurant');
})->name('restaurant');

Route::get('/contact', function(){
   return View::make('pages.contact');
})->name('contact');

/*Admin Routes*/
Route::get('/admin', function(){
   return View::make('pages.admin.dashboard');
})->name('admin');

Route::group(['namespace' => 'Admin'], function () {
    Route::get('/admin/restaurant', 'RestaurantController@index')->name('restaurant.index');
    Route::get('/admin/restaurant/create', 'RestaurantController@create')->name('restaurant.create');
    Route::get('/admin/restaurant/{id}', 'RestaurantController@show')->name('restaurant.show');
    Route::post('/admin/restaurant', 'RestaurantController@store')->name('restaurant.store');
    Route::get('/admin/restaurant-menu/{id}', 'RestaurantController@createmenu')->name('restaurantmenu');
    Route::post('/admin/restaurant-menu-add', 'RestaurantController@addmenu')->name('restaurantmenuadd');

    Route::get('/admin/category', 'CategoryController@index')->name('category.index');
    Route::get('/admin/category/create', 'CategoryController@create')->name('category.create');
    Route::post('/admin/category', 'CategoryController@store')->name('category.store');
});

Route::group(['namespace' => 'Front'], function () {
    Route::get('/restaurant/{id}', 'RestaurantController@show')->name('restaurantfront.show');

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/cart', 'CartController@cart')->name('cart');
        Route::post('/add-to-cart', 'CartController@addtocart')->name('addtocart');
        Route::post('/cart/update', 'CartController@updatecart')->name('updatecart');
        Route::post('/update-cart', 'CartController@updateCart')->name('update.cart');
        Route::post('/delete-cart-item', 'CartController@deleteCartItem')->name('delete.cart.item');
        Route::get('/checkout', 'OrderController@checkout')->name('checkout');
        Route::post('/place-order', 'OrderController@placeOrder')->name('place.order');
    });

    Route::get('/thank-you', 'OrderController@thankYou')->name('thank.you');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
