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
        error_reporting((\App::isLocal() || \App::environment() === 'testing')
            ? E_ALL & ~E_NOTICE & ~E_STRICT & ~E_WARNING
            : 0
        );

        set_time_limit(120);
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
