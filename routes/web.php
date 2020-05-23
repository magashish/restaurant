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

Route::get('/about', function(){
   return View::make('pages.about');
})->name('about');

Route::get('/restaurant', function(){
   return View::make('pages.restaurant');
})->name('restaurant');

Route::get('/restaurant/{id}', 'RestaurantController@show')->name('restaurantfront.show');

Route::get('/contact', function(){
   return View::make('pages.contact');
})->name('contact');

Route::post('/cart', 'CartController@addtocart')->name('addtocart');

/*Admin Routes*/
Route::get('/admin', function(){
   return View::make('pages.admin.dashboard');
})->name('admin');

Route::get('/admin/restaurant', 'Admin\RestaurantController@index')->name('restaurant.index');
Route::get('/admin/restaurant/create', 'Admin\RestaurantController@create')->name('restaurant.create');
Route::get('/admin/restaurant/{id}', 'Admin\RestaurantController@show')->name('restaurant.show');
Route::post('/admin/restaurant', 'Admin\RestaurantController@store')->name('restaurant.store');
Route::get('/admin/restaurant-menu/{id}', 'Admin\RestaurantController@createmenu')->name('restaurantmenu');
Route::post('/admin/restaurant-menu-add', 'Admin\RestaurantController@addmenu')->name('restaurantmenuadd');

Route::get('/admin/category', 'Admin\CategoryController@index')->name('category.index');
Route::get('/admin/category/create', 'Admin\CategoryController@create')->name('category.create');
Route::post('/admin/category', 'Admin\CategoryController@store')->name('category.store');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
