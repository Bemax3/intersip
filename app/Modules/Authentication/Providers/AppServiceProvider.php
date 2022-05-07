<?php

namespace App\Modules\Authentication\Providers;

use App\Modules\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Module's name
     *
     * @var string
     */
    public static $module = "Authentication";

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // 
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        //
    }
}
