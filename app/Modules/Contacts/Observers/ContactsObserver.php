<?php

namespace App\Modules\Contacts\Observers;

use App\Modules\Contacts\Models\Contact;
use Illuminate\Support\Facades\Cache;

class ContactsObserver
{
    /**
     * Handle the Contact "created" event.
     *
     * @param  Contact $contact
     * @return void
     */
    public function created(Contact $contact)
    {
        Cache::forget('contacts');
    }

    /**
     * Handle the Contact "updated" event.
     *
     * @param  Contact $contact
     * @return void
     */
    public function updated(Contact $contact)
    {
        //
    }

    /**
     * Handle the Contact "deleted" event.
     *
     * @param  Contact $contact
     * @return void
     */
    public function deleted(Contact $contact)
    {
        //
    }

    /**
     * Handle the Contact "restored" event.
     *
     * @param  Contact $contact
     * @return void
     */
    public function restored(Contact $contact)
    {
        //
    }

    /**
     * Handle the Contact "force deleted" event.
     *
     * @param  Contact $contact
     * @return void
     */
    public function forceDeleted(Contact $contact)
    {
        //
    }
}
