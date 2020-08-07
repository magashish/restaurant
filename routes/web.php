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

// Route::get('/about', function () {
//     return View::make('pages.about');
// })->name('about');

/*Route::get('/restaurant', function () {
    return View::make('pages.restaurant');
})->name('restaurant');*/

// Route::get('/contact', function () {
//     return View::make('pages.contact');
// })->name('contact');

Route::get('/contact', 'CmsController@contact')->name('contact');
Route::get('/about', 'CmsController@about')->name('about');
Route::get('/carrers', 'CmsController@carrer');
Route::get('/teams', 'CmsController@teams');
Route::get('/terms&conditions', 'CmsController@termsConditions');
Route::get('/refund&cancellation', 'CmsController@refundCancellation');
Route::get('/privacy-policy', 'CmsController@privacyPolicy');
Route::get('/cookie-policy', 'CmsController@cookiePolicy');
Route::get('/help&support', 'CmsController@helpSupport');
Route::get('/partner-with-us', 'CmsController@partnerwithUs');
Route::get('/ride-with-us', 'CmsController@ridewithUs');

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
    Route::any('/admin/restaurant-delete/{id}', 'RestaurantController@deleteRestraunt')->name('restaurant.delete');
    
    Route::get('/admin/restaurant-menu/{id}', 'RestaurantController@createmenu')->name('restaurantmenu');
    Route::post('/admin/restaurant-menu-add', 'RestaurantController@addmenu')->name('restaurantmenuadd');

    Route::get('/admin/category', 'CategoryController@index')->name('category.index');
    Route::get('/admin/category/create', 'CategoryController@create')->name('category.create');
    Route::post('/admin/category', 'CategoryController@store')->name('category.store');
    Route::any('/admin/category-edit/{id}', 'CategoryController@editCategory')->name('category.edit');
    Route::any('/admin/category-update/{id}', 'CategoryController@editCategory')->name('category.update');
    Route::any('/admin/category-delete/{id}', 'CategoryController@deleteCategory')->name('category.delete');

    Route::any('/settings', 'DashboardController@settings')->name('admin.settings');
    Route::any('/cms', 'DashboardController@getCms')->name('admin.cms');
    Route::any('/cms/{id}', 'DashboardController@editCms')->name('cms.edit');

    Route::any('/users', 'UserController@getUsers')->name('admin.users');
    Route::any('/user-details/{id}', 'UserController@userDetails')->name('admin.user.detail');
    Route::any('/users-delete/{id}', 'UserController@deleteUsers')->name('admin.user.delete');

    Route::any('/orders', 'OrderController@getOrders')->name('admin.order');
    Route::any('/order-detail/{id}', 'OrderController@orderDetail')->name('admin.order.detail');
    
    Route::get('/admin/set-delivery-charges', 'DashboardController@deliveryCharges')->name('setdeliverycharge');
    Route::post('/admin/post-delivery-charges', 'DashboardController@postDeliveryCharges')->name('postdeliverycharge');
    Route::get('/admin/view-delivery-charges', 'DashboardController@viewDeliveryCharges')->name('delivery.prices');
    Route::any('/admin/edit-delivery-charges/{id}', 'DashboardController@editDeliveryCharges')->name('delivery.edit');
    Route::any('/admin/update-delivery-charges/{id}', 'DashboardController@editDeliveryCharges')->name('delivery.update');

    // });
});

Route::group(['namespace' => 'Front'], function () {
    Route::post('/user-login', 'UserController@login')->name('user.login');
    Route::post('/user-register', 'UserController@register')->name('user.register');

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
    Route::post('/input-check-tax', 'OrderController@inputcheckTax')->name('input.check.tax');

    Route::group(['middleware' => 'auth'], function () {
    });

    Route::get('/thank-you', 'OrderController@thankYou')->name('thank.you');
    Route::post('/check-same-restaurant', 'CartController@checkSameRestaurant')->name('check-same-restaurant');
    Route::post('/get-product-options', 'CartController@getProductOptions')->name('get-product-options');
    Route::post('/update-lat-lng', 'UserController@updateLatLng')->name('update.lat.lng');
    Route::post('/calculate-delivery-charge', 'OrderController@calculateDeliveryCharge')->name('calculate.delivery.charge');
    Route::post('/input-calculate-delivery-charge', 'OrderController@inputcalculateDeliveryCharge')->name('input.calculate.delivery.charge');

   // Route::group(['middleware' => ['auth:web']], function(){
        //Route::group(['middleware' => ['stripe']], function() {
            Route::get('/', 'HomeController@index')->name('home.index');
        //});
        Route::get('/seller/dashboard', 'SellerController@dashboard')->name('seller.dashboard');

        Route::get('save', 'CustomerController@form')->name('stripe.form');
        Route::post('save', 'CustomerController@save')->name('save.customer');
        Route::get('express', 'SellerController@create')->name('create.express');
        Route::get('stripe', 'SellerController@save')->name('save.express');
    //});

    Route::get('/account', 'AccountController@account')->name('account');
    Route::get('/seller/account', 'AccountController@sellerAccount')->name('seller.account');
    Route::post('/seller/update-profile','UserController@updateSellerProfile')->name('seller.update');;
    Route::get('/link-bank-account','SellerController@getaccountdetail')->name('seller.connect');
    Route::get('/seller/orders','SellerController@sellerOrders')->name('seller.orders');
    Route::get('/seller/view-order-details/{id}','SellerController@viewDetails')->name('order.details');
    Route::post('/seller/vieworderdetails','SellerController@orderDetails')->name('seller.order.details');
    Route::post('/seller/changeOrderStatus','SellerController@changeStatus')->name('seller.changeorder.status');
    Route::any('/seller/store-stripe-account-details','SellerController@storestripedetail')->name('seller.storeconnect');
    Route::any('/seller/delete-stripe-account','SellerController@deletestripeaccount');
    Route::post('/update-profile', 'UserController@updateProfile')->name('update.profile');
    Route::get('/change-password', 'UserController@changePassword')->name('change.password');
    Route::post('/update-password-post', 'UserController@updatePasswordPost')->name('update.password.post');
    Route::get('/my-orders', 'OrderController@myOrders')->name('my.orders');
    Route::get('/order-detail/{oid}', 'OrderController@orderDetail')->name('order.detail');

    Route::get('/saved-address', 'AccountController@savedAddress')->name('saved.address');
    Route::get('/delete-address/{id}', 'AccountController@deleteAddress')->name('delete.address');
});

Auth::routes();
Route::group(['namespace' => 'Front'], function () {
    Route::get('/cart', 'CartController@cart')->name('cart');
});
