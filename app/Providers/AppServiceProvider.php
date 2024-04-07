<?php

namespace App\Providers;

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
        // $clientIP = request()->ip();
        // $allowedIPS = ['10.124.2.7'];
        // if (in_array($clientIP, $allowedIPS)) {
        //     config(['database.default' => 'pgsql']);
        // } else {
        //     config(['database.default' => 'pgsql2']);
        // }
    }
}
