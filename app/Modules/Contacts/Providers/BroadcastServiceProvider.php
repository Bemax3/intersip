<?php

namespace App\Modules\Contacts\Providers;

use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        require module_path(AppServiceProvider::$module, 'routes/channels.php');
    }
}
