<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
		Schema::defaultStringLength(191);
		
		Blade::component('components.textboxaddon', 'textboxaddon');
		Blade::component('components.tripletextboxaddon', 'tripletextboxaddon');
		Blade::component('components.horizontaltextinput', 'horizontaltextinput');
    }
}
