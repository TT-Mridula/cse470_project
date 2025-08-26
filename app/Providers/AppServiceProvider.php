<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bindings / singletons go here if you need them.
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Safe default for older MySQL versions / long indexes
        Schema::defaultStringLength(191);
    }
}
