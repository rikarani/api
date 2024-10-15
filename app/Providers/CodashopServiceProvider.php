<?php

namespace App\Providers;

use App\Services\Codashop;
use Illuminate\Support\ServiceProvider;

class CodashopServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('codashop', Codashop::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
