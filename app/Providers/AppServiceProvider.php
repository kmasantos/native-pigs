<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';
        if ($ip == '3.1.52.82') {
            \Debugbar::enable();
        }
    }
}
