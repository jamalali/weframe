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

//*******************************//
//     Back-end Admin Routes     //
//*******************************//
Route::middleware('role:staff')->name('admin.')->prefix('admin')->group(function() {
    
    Route::get('/', 'Admin\AdminController@index')->name('index');
	
	// Orders Routes
	Route::resource('orders', 'Admin\Orders\AdminOrdersController');
	
	// Settings Routes
	Route::name('settings.')->prefix('settings')->group(function() {
        Route::get('/', 'Admin\Settings\AdminSettingsController@index')->name('index');
		
		Route::resource('pricing', 'Admin\Settings\Pricing\AdminSettingsPricingController')->only(['index', 'store']);
		Route::resource('glazings', 'Admin\Settings\Glazings\AdminSettingsGlazingsController');
    });
    
    // Discounts Routes
    //Route::resource('discounts', 'Admin\Discounts\AdminDiscountsController');
    
    // Customers Routes
//    Route::name('customers.')->prefix('customers')->group(function() {
//        Route::get('/', 'Admin\Customers\AdminCustomersController@index')->name('index');
//        
//        // Warranty Routes
//        Route::name('warranty.')->prefix('warranty')->group(function() {
//            Route::get('/', 'Admin\Customers\Warranty\AdminCustomersWarrantyController@index')->name('index');
//            
//            Route::get('/{warrantySubmission}', 'Admin\Customers\Warranty\AdminCustomersWarrantyController@show')->name('show');
//        });
//    });
    
    // Orders Routes
//    Route::name('orders.')->prefix('orders')->group(function() {
//        Route::get('/', 'Admin\Orders\AdminOrdersController@index')->name('index');
//        
//        Route::get('/{order}/{orderUuid}', 'Admin\Orders\AdminOrdersController@show')->name('show');
//        Route::get('/status-history/{order}/{orderUuid}', 'Admin\Orders\AdminOrdersController@statusHistory')->name('status_history');
//    });
    
    // Staff Routes
    //Route::resource('staff', 'Admin\Staff\AdminStaffController');
    
    //Route::get('/import', 'ImportController@index')->name('import');
    //Route::post('/import-process', 'ImportController@processImport')->name('import.process');
});

Route::get('/', 'HomeController@index')->name('index');

Auth::routes(['register' => false]);