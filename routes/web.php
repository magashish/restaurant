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
});

Route::get('/about', function () {
    return View::make('pages.about');
})->name('about');

/*Route::get('/restaurant', function () {
    return View::make('pages.restaurant');
})->name('restaurant');*/

Route::get('/contact', function () {
    return View::make('pages.contact');
})->name('contact');

/*Admin Routes*/
Route::group(['namespace' => 'Admin'], function () {
    Route::get('/admin/login', 'AdminController@login')->name('admin.login');
    Route::post('/admin/login', 'AdminController@loginPost')->name('admin.login');

    //Route::group(['middleware' => 'auth:admin'], function () {
    Route::get('/admin', 'DashboardController@index')->name('admin');
    Route::get('/admin/dashboard', 'DashboardController@index')->name('admin.dashboard');
    Route::get('/admin/restaurant', 'RestaurantController@index')->name('restaurant.index');
    Route::get('/admin/restaurant/create', 'RestaurantController@create')->name('restaurant.create');
    Route::get('/admin/restaurant/{id}', 'RestaurantController@edit')->name('restaurant.show');
    Route::post('/admin/restaurant', 'RestaurantController@store')->name('restaurant.store');
    Route::post('/admin/restaurant-update', 'RestaurantController@update')->name('restaurant.update');
    Route::get('/admin/restaurant-menu/{id}', 'RestaurantController@createmenu')->name('restaurantmenu');
    Route::post('/admin/restaurant-menu-add', 'RestaurantController@addmenu')->name('restaurantmenuadd');

    Route::get('/admin/category', 'CategoryController@index')->name('category.index');
    Route::get('/admin/category/create', 'CategoryController@create')->name('category.create');
    Route::post('/admin/category', 'CategoryController@store')->name('category.store');

    Route::get('/settings', 'DashboardController@settings')->name('admin.settings');
    Route::post('/save-settings', 'DashboardController@saveSettings')->name('admin.save.settings');
    // });
});

Route::group(['namespace' => 'Front'], function () {
    Route::post('/user-login', 'UserController@login')->name('user.login');


    Route::get('/properties', 'PropertyControllcheckouter@index')->name('property.index');
    Route::get('/search', 'SearchController@index')->name('search');

    Route::get('/restaurant/{id}', 'RestaurantController@show')->name('restaurantfront.show');
    Route::get('/restaurants', 'RestaurantController@allrestaurant')->name('restaurantfront.all');
    //Route::get('/restaurant', 'RestaurantController@allRestaurantList')->name('restaurant.all');

    Route::get('/cart', 'CartController@cart')->name('cart');
    Route::post('/add-to-cart', 'CartController@addtocart')->name('addtocart');
    Route::post('/cart/update', 'CartController@updatecart')->name('updatecart');
    Route::post('/update-cart', 'CartController@updateCart')->name('update.cart');
    Route::post('/delete-cart-item', 'CartController@deleteCartItem')->name('delete.cart.item');
    Route::get('/checkout', 'OrderController@checkout')->name('checkout');
    Route::post('/place-order', 'OrderController@placeOrder')->name('place.order');
    Route::post('/check-tax', 'OrderController@checkTax')->name('check.tax');

    Route::group(['middleware' => 'auth'], function () {
    });

    Route::get('/thank-you', 'OrderController@thankYou')->name('thank.you');
    Route::post('/check-same-restaurant', 'CartController@checkSameRestaurant')->name('check-same-restaurant');
    Route::post('/update-lat-lng', 'UserController@updateLatLng')->name('update.lat.lng');
    Route::post('/calculate-delivery-charge', 'OrderController@calculateDeliveryCharge')->name('calculate.delivery.charge');

   // Route::group(['middleware' => ['auth:web']], function(){
        //Route::group(['middleware' => ['stripe']], function() {
            Route::get('/', 'HomeController@index')->name('home.index');
        //});

        Route::get('save', 'CustomerController@form')->name('stripe.form');
        Route::post('save', 'CustomerController@save')->name('save.customer');
        Route::get('express', 'SellerController@create')->name('create.express');
        Route::get('stripe', 'SellerController@save')->name('save.express');
    //});
});

Auth::routes();
Route::group(['namespace' => 'Front'], function () {
    Route::get('/cart', 'CartController@cart')->name('cart');
});
