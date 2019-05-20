<?php

Route::middleware('role:staff')->group(function() {
	
	Route::get('/', 'IndexController@index')->name('index');
	
	// Orders Routes
	Route::resource('orders', 'Orders\OrdersController')->except([
		'store'
	]);
	Route::resource('orders.lines', 'Orders\Lines\OrdersLinesController');
	
	// Mounts, Mount Variants
	Route::resource('mounts', 'Mounts\MountsController');
	Route::resource('mounts.variants', 'Mounts\Variants\MountsVariantsController');
	
	// Moulds
	Route::resource('moulds', 'Moulds\MouldsController');
	
	// Settings Routes
	Route::name('settings.')->prefix('settings')->group(function() {
        Route::get('/', 'Settings\SettingsController@index')->name('index');
		
		Route::resource('pricing', 'Settings\Pricing\SettingsPricingController')->only(['index', 'store']);
		Route::resource('glazings', 'Settings\Glazings\SettingsGlazingsController');
    });
    
});

Auth::routes(['register' => false]);