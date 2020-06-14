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

use Illuminate\Support\Facades\App;

Route::get('/lang/{locale}', function ($locale){
    App::setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
});

//---------------------

//Clear Cache facade value:
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Route cache:
Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function() {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Cache Config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});

//Clear Config cache:
Route::get('/config-clear', function() {
    $exitCode = Artisan::call('config:clear');
    return '<h1>Clear Config cleared</h1>';
});

//---------------------------------------

Route::get('/permission', function(){
    return view('admin.access');
});

Route::get('/admin/login', 'Admin\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('/admin/login', 'Admin\AdminLoginController@login')->name('admin.login.post');
Route::post('/admin/logout', 'Admin\AdminLoginController@logout')->name('admin.logout');

Route::group(['namespace' => 'Admin', 'middleware' => 'admin'], function (){
    //Ajax
    Route::post('/getToken', 'AdminServiceController@getToken')->name('getToken');
    Route::get('/getType', 'AdminServiceController@type')->name('getType');
    // Dashboard
    Route::get('/', 'AdminDashboardController@home')->name('dashboard');
    // Users Admin
    Route::get('/users', 'AdminUserController@index')->name('all_users');
    Route::get('/add_user', 'AdminUserController@addUser');
    Route::post('/add_user', 'AdminUserController@storeUser')->name('store_user');
    Route::get('/edit_user/{id}', 'AdminUserController@editUser')->name('edit_user');
    Route::post('/edit_user/{id}', 'AdminUserController@updateUser')->name('update_user');
    Route::delete('/delete_user/{id}', 'AdminUserController@destroyUser')->name('delete_user');
    //Users Super Admin
    Route::get('/users/{id}', 'AdminUserController@indexAdmin')->name('admin_users');
    // Services
    Route::get('/services', 'AdminServiceController@index')->name('all_services');
    Route::get('/add_service', 'AdminServiceController@addService');
    Route::post('/add_service', 'AdminServiceController@storeService')->name('store_service');
    Route::get('/edit_service/{id}', 'AdminServiceController@editService')->name('edit_service');
    Route::post('/edit_service/{id}', 'AdminServiceController@updateService')->name('update_service');
    Route::delete('/delete_service/{id}', 'AdminServiceController@destroyService')->name('delete_service');
    //Service Client
    Route::get('/service_client/{id}', 'AdminServiceClientController@index')->name('service_client');
    Route::get('/add_service_client/{id}', 'AdminServiceClientController@addServiceClient')->name('add_service_client');
    Route::post('/add_service_client', 'AdminServiceClientController@storeServiceClient')->name('store_service_client');
    Route::get('/edit_service_client/{id}', 'AdminServiceClientController@editServiceClient')->name('edit_service_client');
    Route::post('/edit_service_client/{id}', 'AdminServiceClientController@updateServiceClient')->name('update_service_client');
    Route::delete('/delete_service_client/{id}', 'AdminServiceClientController@destroyServiceClient')->name('delete_service_client');
    // Cities - AJAX
    Route::get('/cities', 'AdminCityController@index')->name('all_cities');
    Route::post('/add_city', 'AdminCityController@storeCity')->name('store_city');
    Route::post('/edit_city', 'AdminCityController@editCity')->name('edit_city');
    Route::post('/update_city', 'AdminCityController@updateCity')->name('update_city');
    Route::delete('/delete_city/{id}', 'AdminCityController@destroyCity')->name('delete_city');
    // Areas - AJAX
    Route::get('/areas', 'AdminAreaController@index')->name('all_areas');
    Route::post('/add_area', 'AdminAreaController@storeArea')->name('store_area');
    Route::post('/edit_area', 'AdminAreaController@editArea')->name('edit_area');
    Route::post('/update_area', 'AdminAreaController@updateArea')->name('update_area');
    Route::delete('/delete_area/{id}', 'AdminAreaController@destroyArea')->name('delete_area');
    // Categories - AJAX
    Route::get('/categories', 'AdminCategoryController@index')->name('all_categories');
    Route::post('/add_category', 'AdminCategoryController@storeCategory')->name('store_category');
    Route::post('/edit_category', 'AdminCategoryController@editCategory')->name('edit_category');
    Route::post('/update_category', 'AdminCategoryController@updateCategory')->name('update_category');
    Route::delete('/delete_category/{id}', 'AdminCategoryController@destroyCategory')->name('delete_category');
    // Brands - AJAX
    Route::get('/brands', 'AdminBrandController@index')->name('all_brands');
    Route::post('/add_brand', 'AdminBrandController@storeBrand')->name('store_brand');
    Route::post('/edit_brand', 'AdminBrandController@editBrand')->name('edit_brand');
    Route::post('/update_brand', 'AdminBrandController@updateBrand')->name('update_brand');
    Route::delete('/delete_brand/{id}', 'AdminBrandController@destroyBrand')->name('delete_brand');
    // Banners - AJAX
    Route::get('/banners', 'AdminBannerController@index')->name('all_banners');
    Route::post('/add_banner', 'AdminBannerController@storeBanner')->name('store_banner');
    Route::post('/edit_banner', 'AdminBannerController@editBanner')->name('edit_banner');
    Route::post('/update_banner', 'AdminBannerController@updateBanner')->name('update_banner');
    Route::delete('/delete_banner/{id}', 'AdminBannerController@destroyBanner')->name('delete_banner');
    // Products
    Route::get('/products', 'AdminProductController@index')->name('all_products');
    Route::get('/add_product', 'AdminProductController@addProduct');
    Route::post('/add_product', 'AdminProductController@storeProduct')->name('store_product');
    Route::get('/edit_product/{id}', 'AdminProductController@editProduct')->name('edit_product');
    Route::post('/edit_product/{id}', 'AdminProductController@updateProduct')->name('update_product');
    Route::delete('/delete_product/{id}', 'AdminProductController@destroyProduct')->name('delete_product');
    // Product Title
    Route::get('/titles/{id}', 'AdminProductTitleController@index')->name('all_titles');
    Route::get('/add_title/{id}', 'AdminProductTitleController@addTitle')->name('add_title');
    Route::post('/add_title', 'AdminProductTitleController@storeTitle')->name('store_title');
    Route::get('/edit_title/{id}', 'AdminProductTitleController@editTitle')->name('edit_title');
    Route::post('/edit_title/{id}', 'AdminProductTitleController@updateTitle')->name('update_title');
    Route::delete('/delete_title/{id}', 'AdminProductTitleController@destroyTitle')->name('delete_title');
    // Images - AJAX
    Route::get('/image_product/{id}', 'AdminImageController@index')->name('all_images');
    Route::post('/add_image', 'AdminImageController@storeImage')->name('store_image');
    Route::delete('/delete_image/{id}', 'AdminImageController@destroyImage')->name('delete_image');
    // Orders
    Route::get('/orders', 'AdminOrderController@index')->name('all_orders');
    Route::get('/orders/{id}', 'AdminOrderController@indexAdmin')->name('admin_orders');
    Route::get('/show_order/{id}', 'AdminOrderController@showOrder')->name('show_order');
    Route::post('/order_notify', 'AdminOrderController@order_notify')->name('order_notify');
    Route::get('/order_count', 'AdminOrderController@order_count')->name('order_count');
    Route::post('/status/{id}', 'AdminOrderController@status')->name('status');
    // Pages
    Route::get('/edit_page', 'AdminPageController@edit')->name('edit_page');
    Route::post('/edit_page/{id}', 'AdminPageController@update')->name('update_page');
    // Notification
    Route::get('notifications', 'AdminNotificationController@index');
    Route::get('/add_notification', 'AdminNotificationController@create');
    Route::post('/add_notification', 'AdminNotificationController@store')->name('store_notification');
    Route::delete('/delete_notification/{id}', 'AdminNotificationController@destroy')->name('delete_notification');
    // contact us
    Route::get('contact', 'AdminContactController@index');
    Route::post('contact', 'AdminContactController@store')->name('store_contact');
    Route::get('contacts', 'AdminContactController@showAll')->name('contacts');
    Route::get('contactsAdmin', 'AdminContactController@showAllAdmin')->name('contactsAdmin');
    Route::post('contact_notify', 'AdminContactController@contact_notify')->name('contact_notify');
    Route::get('get_contact', 'AdminContactController@getContacts')->name('contact_count');
    Route::post('contact_notifyAdmin', 'AdminContactController@contact_notifyAdmin')->name('contact_notifyAdmin');
    Route::get('get_contactAdmin', 'AdminContactController@getContactsAdmin')->name('contact_countAdmin');
    Route::delete('contact_delete/{id}', 'AdminContactController@destroyContact')->name('contact_delete');
    // rates
    Route::get('rates', 'AdminRateController@index');
    Route::delete('rate_delete/{id}', 'AdminRateController@destroy')->name('rate_delete');
    // Edit Profile
    Route::get('/edit_profile/{id}', 'AdminLoginController@editProfile')->name('edit_profile');
    Route::post('/edit_profile/{id}', 'AdminLoginController@updateProfile')->name('update_profile');
    // Reminders
    Route::get('reminders', 'AdminReminderController@index');

});


