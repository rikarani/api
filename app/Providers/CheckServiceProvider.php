<?php

namespace App\Providers;

use App\Services\Check;
use Illuminate\Support\ServiceProvider;

class CheckServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('check', Check::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
