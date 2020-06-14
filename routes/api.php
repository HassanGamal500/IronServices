<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api'], function() {
    //Auth
    Route::post('sign_in', 'AuthController@login');
    Route::post('sign_up', 'AuthController@register');
    Route::post('reset_password', 'AuthController@resetPassword');
    Route::post('pin_code', 'AuthController@pinCode');
    Route::post('new_password', 'AuthController@newPassword');
    Route::post('get_profile', 'AuthController@getProfile');
    Route::post('update_profile', 'AuthController@updateProfile');
    Route::post('loginWithSocial', 'AuthController@loginWithSocial');
    //Address
    Route::post('get_cities', 'AddressController@getCities');
    Route::post('get_areas', 'AddressController@getAreas');
    Route::post('address', 'AddressController@address');
    Route::post('all_address', 'AddressController@allAddress');
    Route::post('get_address', 'AddressController@getAddress');
    Route::post('update_address', 'AddressController@UpdateAddress');
    Route::post('delete_address', 'AddressController@deleteAddress');
    //Setting
    Route::post('page', 'SettingController@page');
    Route::post('contact_us', 'SettingController@contactUs');
    Route::post('setLangUser', 'SettingController@setLangUser');
    //App
    Route::post('histories', 'AppController@Histories');
    Route::post('notifications', 'AppController@notifications');
    Route::post('rates', 'AppController@rates');
    Route::post('all_rates', 'AppController@allRates');
    Route::post('order_detail', 'AppController@orderDetail');
    //Service
    Route::post('service', 'ServiceController@home');
    Route::post('products', 'ServiceController@products');
    Route::post('detail_product', 'ServiceController@detailProduct');
    Route::post('categories', 'ServiceController@categories');
    Route::post('category_product', 'ServiceController@category_product');
    Route::post('make_order', 'ServiceController@makeOrder');
    Route::post('order_status', 'ServiceController@orderStatus');
    //Reminder
    Route::post('reminders', 'ReminderController@reminders');
    Route::post('add_reminder', 'ReminderController@addReminder');
    Route::post('cancel_reminder', 'ReminderController@cancelReminder');
});
