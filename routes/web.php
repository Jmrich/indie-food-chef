<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

use App\Customer;
use App\Geocoder;
use App\Kitchen;
use App\Order;
use App\Services\ChargeService;
use Carbon\Carbon;

Route::singularResourceParameters();

Route::get('/test', function (ChargeService $chargeService) {

});

Auth::routes();

Route::get('/', 'WelcomeController@show');

Route::get('/home', 'HomeController@show');

Route::get('/search', 'SearchController@byLocation')->name('search-by-location');

Route::get('/customer/current', 'CustomerController@current')->name('customer.current');

Route::get('/user/current', 'UserController@current')->name('user.current');

Route::get('/chef/current', 'ChefController@current')->name('chef.current');

Route::get('account', 'Account\AccountController@index')->name('account');

Route::resource('kitchens', 'KitchenController');

Route::post('bag', 'BagController@saveBagToSession');

Route::group(['prefix' => 'account'], function () {
    // Profile
    Route::put('profile', 'Account\ProfileController@update')->name('profile.update');

    // Security
    Route::put('password', 'Account\Security\PasswordController@update');

    // Payment Method
    if (App\Ifc::isCustomer()) {
        Route::put('payment-method', 'Billing\PaymentMethodController@update');
    }
});

//Route::resource('addresses', 'AddressController');

// Customer routes
Route::group(['middleware' => 'customer'], function () {
    /*Route::get('/', function () {
        return view('welcome');
    });*/

    Route::get('bag/current', 'BagController@current');

    Route::get('/order/review', 'Orders\OrderController@showOrderReview')->name('order-review');

    Route::resource('orders', 'Orders\OrderController');

    Route::resource('checkout', 'CheckoutController');

    Route::put('payment-methods', 'Billing\PaymentMethodController@update');

    Route::resource('payment-methods', 'Billing\PaymentMethodController');

    Route::resource('addresses', 'CustomerAddressController');
});

// Chef routes
Route::group(['prefix' => 'chef', 'middleware' => 'chef'], function () {
    Route::resource('dishes', 'Chef\DishController');

    Route::resource('chef-addresses', 'Chef\AddressController');

    Route::post('orders/{order}/complete', 'Chef\OrderController@complete')->name('complete-order');

    Route::post('orders/{order}/cancel', 'Chef\OrderController@cancel')->name('cancel-order');

    Route::post('orders/{order}/refund', 'Chef\OrderController@refund')->name('refund-order');

    Route::resource('orders', 'Chef\OrderController', ['names' => [
        'index' => 'chef.orders.index',
        'create' => 'chef.orders.create',
        'store' => 'chef.orders.store',
        'show' => 'chef.orders.show',
        'edit' => 'chef.orders.edit',
        'update' => 'chef.orders.update',
        'destroy' => 'chef.orders.destroy'
    ]]);

    Route::resource('menus.sections', 'Chef\SectionController');

    Route::resource('menus', 'Chef\MenuController');

    Route::resource('hours', 'Chef\HoursController');
});
