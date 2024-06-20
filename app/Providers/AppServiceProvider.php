<?php

namespace App\Providers;

use Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::if('administrator', function () {
            return auth()->user() && auth()->user()->role == 2;
        });
        Blade::if('manager', function () {
            return auth()->user() && auth()->user()->role == 1;
        });
        Blade::if('worker', function () {
            return auth()->user() && auth()->user()->role == 0;
        });
    }
}
