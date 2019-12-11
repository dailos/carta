<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Components alias
        Blade::component('components.collapse', 'collapse');
        Blade::component('components.laravel-error', 'errorlaravel');
        Blade::component('components.veevalidate-error', 'errorvee');
        Blade::component('components.modal-save', 'modalsave');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
