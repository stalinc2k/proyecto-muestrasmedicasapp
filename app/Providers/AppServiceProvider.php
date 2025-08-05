<?php

namespace App\Providers;

use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        \App\Models\Zone::class => \App\Policies\ZonePolicy::class,
    ];

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::aliasMiddleware('admin', IsAdmin::class);
    }
}
