<?php

namespace App\Modules\Contacts\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Modules\Contacts\Models\Contact;
use App\Modules\Contacts\Models\Property;
use App\Modules\Contacts\Models\ContactList;
use App\Modules\Contacts\Models\ContactProperty;
use App\Modules\Contacts\Http\Resources\ContactsResource;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

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
    public function searchForUser(Request $request,$user) {
        $data = json_decode($request->getContent());
        if(array_key_exists('keywords',(array)$data)) $keywords = $data->keywords;
        else return response('Keywords missing in request body');
        $list_id = User::findOrFail($user)->lists()->first()->id;
        return ContactsResource::collection(
            Contact::query()
                ->where('contact_phone_number','LIKE',"%{$keywords}%")
                ->orwhereHas('properties',function(EloquentBuilder $query) use ($keywords) {
                    $query->where('contact_properties.value','LIKE',"%{$keywords}%");
                })
                ->where('contact_list_id',$list_id)
                ->get()
        );
    }
    
    public function getContactsOfUser($id) {
        $list = User::findOrFail($id)->lists()->first();
        return ContactsResource::collection(Contact::query()->where('contact_list_id',$list->id)->get());
    }

    public function store(Request $request,$user) {
        
        $data = json_decode($request->getContent());
        try {
            DB::beginTransaction();
            $user = User::findOrFail($user);
            $listId = $user->lists()->first()->id;
            if(!$data->number) return response('Phone Number can\'t be Empty');
            $phone = $data->number;
            $phoneExist = Contact::query()->where('contact_list_id',$listId)->where('contact_phone_number',$phone)->first();
            if(!$phoneExist) {   
                $new_contact = ContactList::find($listId)->contacts()->create([
                    'country_id' => $user->country_id,
                    'contact_phone_number' => $phone,
                    'created_by' => $user
                ]);
                if(array_key_exists('props',(array)$data))
                    foreach ($data->props as $key => $property) {
                        $prop = Property::query()->where('contact_list_id',$listId)->whereRaw('lower(property_name) like (?)',strtolower($property->name))->first();
                        $new_contact->properties()->attach($prop->id,['value'=>$property->value]);
                    }
                $new_contact->save();
                DB::commit();
                return response($new_contact,200);
            } else {
                $old_contact = Contact::query()->where('contact_list_id',$listId)->where('contact_phone_number',$phone)->first();
                if(array_key_exists('props',(array)$data))
                    foreach ($data->props as $key => $property) {
                        $prop = Property::query()->where('contact_list_id',$listId)->whereRaw('lower(property_name) like (?)',strtolower($property->name))->first();
                        $contact_props = ContactProperty::query()->where('contact_id',$old_contact->id)->where('property_id',$prop->id)->first();
                        if($contact_props) $old_contact->properties()->updateExistingPivot($prop->id,['value'=>$property->value]);
                        else $old_contact->properties()->attach($prop->id,['value'=>$property->value]);
                    }
                DB::commit();
                return response($old_contact,200);
            }
        } catch (\Exception $th) {
            return response('Error :'. $th,400);
            DB::rollBack();
        }
    }

    public function update(Request $request,$user) {
        $data = json_decode($request->getContent());
        if(!$data->number) return response('Phone Number can\'t be Empty');
        try {
            DB::beginTransaction();
            $user = User::findOrFail($user);
            $listId = $user->lists()->first()->id;
            $phone = $data->number;
            $contact = Contact::query()->where('contact_phone_number',$phone)->where('contact_list_id',$listId)->first();
            if(!$contact) return response('Contact Not Found !',400);
            if(array_key_exists('props',(array)$data))
                foreach ($data->props as $key => $property) {
                    if($property->value !== "") {
                        $prop = Property::query()->where('contact_list_id',$listId)->whereRaw('lower(property_name) like (?)',strtolower($property->name))->first();
                        $contact_props = ContactProperty::query()->where('contact_id',$contact->id)->where('property_id',$prop->id)->first();
                        if($contact_props) $contact->properties()->updateExistingPivot($prop->id,['value'=>$property->value]);
                        else $contact->properties()->attach($prop->id,['value'=>$property->value]);
                    }
                }
            $contact->save();
            DB::commit();
            return response($contact,200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response('Error :' . $th,400);
        }
    }
    public function destroy(Request $request,$user){
        $data = json_decode($request->getContent());        
        try {
            DB::beginTransaction();
            $user = User::findOrFail($user);
            $listId = $user->lists()->first()->id;
            if(!array_key_exists('number',(array)$data)) return response('Number is required',400);
            $phone = $data->number;
            $contact = Contact::query()->where('contact_phone_number',$phone)->where('contact_list_id',$listId)->first();
            if($contact) $contact->delete();
            else return response('Contact Not Found',400);
            DB::commit();
            return response('Deleted',200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response('Error While Deleting : '. $th,400);
        }
    }

}
