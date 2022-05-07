<?php

namespace App\Modules\Contacts\Providers;

use App\Modules\Contacts\Models\Contact;
use App\Modules\Contacts\Observers\ContactsObserver;
use App\Modules\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Module's name
     *
     * @var string
     */
    public static $module = "Contacts";

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
        Contact::observe(ContactsObserver::class);
        //
    }
}
