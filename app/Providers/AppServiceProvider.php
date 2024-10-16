<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Codashop;
use App\Services\Check;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton("check", Check::class);
        $this->app->singleton("codashop", Codashop::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
