<?php

namespace App\Modules\Contacts\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Contacts\Http\Resources\ContactsResource;
use App\Modules\Contacts\Models\Contact;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getContacts()
    {
        return ContactsResource::collection(Cache::remember('contacts',60*60*24,function () {
            return Contact::all();
        }));
        
    }

    public function getContactById($id) {       
        return new ContactsResource(Contact::findOrFail($id));
    }

    public function search($keywords) {
        return ContactsResource::collection(
            Contact::query()
                ->where('contact_phone_number','LIKE',"%{$keywords}%")
                ->orwhereHas('properties',function(EloquentBuilder $query) use ($keywords) {
                    $query->where('contact_properties.value','LIKE',"%{$keywords}%");
                })
                ->get()
        );
    }
    
    public function getContactsOfUser($id) {
        $list = User::findOrFail($id)->lists()->first();
        return ContactsResource::collection(Contact::query()->where('contact_list_id',$list->id)->get());
    }

    

}
