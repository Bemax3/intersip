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
use Illuminate\Support\Facades\Auth;

/**
 * @group Contacts 
 *
 * API endpoints for managing contacts
 */
class ContactsController extends Controller
{
    /**
     * Get All the contacts.
     *
     * @queryParam   properties   boolean  optional    Get Properties of contacts or not. Example: true
     *
     * @response {
     * "data": [
     *     {
     *      "number": "00000000",
     *      "country": {
     *          "name": "Country",
     *          "calling_code": "code",
     *          "iso2": "iso"
     *       },
     *      "props": [
     *         {
     *             "prop1": "value1"
     *         },
     *         {
     *             "prop2": "value2"
     *         },
     *         ...
     *      ]
     *      },
     *      ...
     * ]
     * }
     * 
     * @response {
     * "data" : [
     *     {
     *      "number": "00000000",
     *      "country": {
     *         "name": "Country",
     *         "calling_code": "code",
     *         "iso2": "iso"
     *      }
     *     },
     *     ...
     * ] 
     * }
     * @response {
     *     "data": []
     * }
    */  
    public function getContacts()
    {
        return ContactsResource::collection(Cache::remember('contacts',60*60*24,function () {
            return Contact::all();
        }));
        
    }
    /**
     * Get contact by Id.
     *
     * @queryParam   properties   boolean  optional    Get Properties of contacts or not. Example: true
     *
     * @response {
     * "data" : [
     *     {
     *      "number": "00000000",
     *      "country": {
     *         "name": "Country",
     *         "calling_code": "code",
     *         "iso2": "iso"
     *      },
     *      "props": [
     *         {
     *             "prop1": "value1"
     *         },
     *         {
     *             "prop2": "value2"
     *         },
     *         ...
     *      ]
     *     }
     * ] 
     * }
     * 
     * @response {  
     * "data" : [
     *     {
     *      "number": "00000000",
     *      "country": {
     *         "name": "Country",
     *         "calling_code": "code",
     *         "iso2": "iso"
     *      }
     *     }
     * ] 
     * }
     * @response 401{
     *    { "message": "Contact Not Found"}
     * }
    */
    public function getContactById($id) {
        $contact = Contact::find($id);        
        if($contact) return new ContactsResource($contact);
        else return response(["message" => "Contact Not Found"],401);
    }
    /**
     * Search Contacts using number or properties
     *
     * @queryParam   properties   boolean  optional    Get Properties of contacts or not. Example: true
     *
     * @response {
     * "data" : [
     *     {
     *      "number": "00000000",
     *      "country": {
     *         "name": "Country",
     *         "calling_code": "code",
     *         "iso2": "iso"
     *      },
     *      "props": [
     *         {
     *             "prop1": "value1"
     *         },
     *         {
     *             "prop2": "value2"
     *         },
     *         ...
     *      ]
     *     },
     *     ...
     * ] 
     * }
     * 
     * @response {  
     * "data" : [
     *     {
     *      "number": "00000000",
     *      "country": {
     *         "name": "Country",
     *         "calling_code": "code",
     *         "iso2": "iso"
     *      }
     *     },
     *     ...
     * ] 
     * }
     * @response 401{
     * { "data": [] } 
     * }
    */
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

     /**
     * Search Contacts of a user using number or properties
     *
     * @bodyParam    keywords string required Keywords to search for. Example: 1001
     * @queryParam   properties   boolean  optional    Get Properties of contacts or not. Example: true
     *
     * @authenticated
     * 
     * @response {
     * "data" : [
     *     {
     *      "number": "00000000",
     *      "country": {
     *         "name": "Country",
     *         "calling_code": "code",
     *         "iso2": "iso"
     *      },
     *      "props": [
     *         {
     *             "prop1": "value1"
     *         },
     *         {
     *             "prop2": "value2"
     *         },
     *         ...
     *      ]
     *     },
     *     ...
     * ] 
     * }
     * 
     * @response {  
     * "data" : [
     *     {
     *      "number": "00000000",
     *      "country": {
     *         "name": "Country",
     *         "calling_code": "code",
     *         "iso2": "iso"
     *      }
     *     },
     *     ...
     * ] 
     * }
     * 
     * @response 401 {
     * { "data": [] } 
     * }
     * 
     * @response 401 {
     * { "message":"Keywords missing in request body" } 
     * }
     * 
     * @response 401
     * {
     *   "message": "Unauthenticated."
     * }
    */
    public function searchForUser(Request $request,$user=null) {
        if(!$user) $user_id = Auth::user()->id;
        else $user_id = $user;
        $data = json_decode($request->getContent());
        if(array_key_exists('keywords',(array)$data)) $keywords = $data->keywords;
        else return response(['message' => 'Keywords missing in request body'],401);
        $list_id = User::findOrFail($user_id)->lists()->first()->id;
        return ContactsResource::collection(
            Contact::query()
            ->where('contact_list_id',$list_id)
            ->where('contact_phone_number','LIKE',"%{$keywords}%")
            ->orwhereHas('properties',function(EloquentBuilder $query) use ($keywords) {
                $query->where('contact_properties.value','LIKE',"%{$keywords}%");
            })
                ->get()
        );
    }
    /**
     * Get All Contacts of a user
     *
     * @authenticated
     *
     * @queryParam   properties   boolean  optional    Get Properties of contacts or not. Example: true
     * 
     * @response {
     * "data" : [
     *     {
     *      "number": "00000000",
     *      "country": {
     *         "name": "Country",
     *         "calling_code": "code",
     *         "iso2": "iso"
     *      },
     *      "props": [
     *         {
     *             "prop1": "value1"
     *         },
     *         {
     *             "prop2": "value2"
     *         },
     *         ...
     *      ]
     *     },
     *     ...
     * ] 
     * }
     * 
     * @response {  
     * "data" : [
     *     {
     *      "number": "00000000",
     *      "country": {
     *         "name": "Country",
     *         "calling_code": "code",
     *         "iso2": "iso"
     *      }
     *     },
     *     ...
     * ] 
     * }
     * 
     * @response 401 {
     * { "data": [] } 
     * }
     * 
     * 
     * @response 401
     * {
     *   "message": "Unauthenticated."
     * }
    */
    public function getContactsOfUser($user_id=null) {
        if(!$user_id) $user_id = Auth::user()->id;
        else $user_id = $user_id;
        $list = User::findOrFail($user_id)->lists()->first();
        return ContactsResource::collection(Contact::query()->where('contact_list_id',$list->id)->get());
    }
    /**
     * Create Contact for user
     * @bodyParam number string required Number to create. Example: 1001
     * @bodyParam props json optional Props of the user.
     * @authenticated
     *
     * @response {
     *  {
     *      "country_id": country_id,
     *      "contact_phone_number": "phone",
     *      "created_by": user_id,
     *      "contact_list_id": list_id,
     *      "updated_at": "2022-05-11T22:13:28.000000Z",
     *      "created_at": "2022-05-11T22:13:28.000000Z",
     *      "id": id
     * }
     * }
     * 
     * @response 401
     * {
     *   "message": "Unauthenticated."
     * }
     * 
     * @response 401
     * {
     *   "message": "Missing Body param Number."
     * }
     * @response 401
     * {
     *   "message": "Using Wrong Property Names."
     * }
    */
    public function store(Request $request,$user=null) {
        if(!$user) $user_id = Auth::user()->id;
        else $user_id = $user;
        $created_by = Auth::user()->id;
        $data = json_decode($request->getContent());
        if(!$data->number) return response(['message'=>'Missing Body param Number'],401);
        try {
            DB::beginTransaction();
            $user = User::findOrFail($user_id);
            $list_id = $user->lists()->first()->id;
            
            $phone = $data->number;
            $phoneExist = Contact::query()->where('contact_list_id',$list_id)->where('contact_phone_number',$phone)->first();
            if(!$phoneExist) {   
                $new_contact = ContactList::find($list_id)->contacts()->create([
                    'country_id' => $user->country_id,
                    'contact_phone_number' => $phone,
                    'created_by' => $created_by
                ]);
                $props = Property::query()->where('contact_list_id',$list_id)->get();
                foreach ($props as $prop) {
                    $new_contact->properties()->attach($prop->id,['value'=> '']);
                }
                if(array_key_exists('props',(array)$data))
                    foreach ($data->props as $key => $property) {
                        $prop = Property::query()->where('contact_list_id',$list_id)->whereRaw('lower(property_name) like (?)',strtolower($property->name))->first();
                        $new_contact->properties()->updateExistingPivot($prop->id,['value'=>$property->value]);
                    }
                $new_contact->save();
                DB::commit();
                return response($new_contact,200);
            } else {
                $old_contact = Contact::query()->where('contact_list_id',$list_id)->where('contact_phone_number',$phone)->first();
                if(array_key_exists('props',(array)$data))
                    foreach ($data->props as $key => $property) {
                        $prop = Property::query()->where('contact_list_id',$list_id)->whereRaw('lower(property_name) like (?)',strtolower($property->name))->first();
                        $contact_props = ContactProperty::query()->where('contact_id',$old_contact->id)->where('property_id',$prop->id)->first();
                        if($contact_props) $old_contact->properties()->updateExistingPivot($prop->id,['value'=>$property->value]);
                        else $old_contact->properties()->attach($prop->id,['value'=>$property->value]);
                    }
                DB::commit();
                return response($old_contact,200);
            }
        } catch (\Exception $th) {
            return response(['message' => 'Using Wrong Property Names'],400);
            DB::rollBack();
        }
    }
   /**
     * Update Contact for user
     * @bodyParam number string required Number to update. Example: 1001
     * @bodyParam props json optional Props of the user.
     * @authenticated
     *
     * @response {
     *  {
     *      "country_id": country_id,
     *      "contact_phone_number": "phone",
     *      "created_by": user_id,
     *      "contact_list_id": list_id,
     *      "updated_at": "2022-05-11T22:13:28.000000Z",
     *      "created_at": "2022-05-11T22:13:28.000000Z",
     *      "id": id
     * }
     * }
     * 
     * @response 401
     * {
     *   "message": "Unauthenticated."
     * }
     * 
     * @response 401
     * {
     *   "message": "Missing Body param Number."
     * }
     * @response 401
     * {
     *   "message": "Using Wrong Property Names."
     * }
    */
    public function update(Request $request,$user=null) {
        $data = json_decode($request->getContent());
        if(!$data->number) return response('Phone Number can\'t be Empty');
        try {
            DB::beginTransaction();
            if(!$user) $user_id = Auth::user()->id;
            else $user_id = $user;
            $user = User::findOrFail($user_id);
            $list_id = $user->lists()->first()->id;
            $phone = $data->number;
            $contact = Contact::query()->where('contact_phone_number',$phone)->where('contact_list_id',$list_id)->first();
            if(!$contact) return response('Contact Not Found !',400);
            if(array_key_exists('props',(array)$data))
                foreach ($data->props as $key => $property) {
                    if($property->value !== "") {
                        $prop = Property::query()->where('contact_list_id',$list_id)->whereRaw('lower(property_name) like (?)',strtolower($property->name))->first();
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

    /**
     * Delete Contact for user
     * @bodyParam number string required Number to delete. Example: 1001
     * 
     * @authenticated
     *
     * @response 401
     * {
     *   "message": "Deleted."
     * }
     * 
     * @response 401
     * {
     *   "message": "Unauthenticated."
     * }
     * 
     * @response 401
     * {
     *   "message": "Missing Body param Number."
     * }
    */
    public function destroy(Request $request,$user=null){
        $data = json_decode($request->getContent());        
        try {
            DB::beginTransaction();
            if(!$user) $user_id = Auth::user()->id;
            else $user_id = $user;
            $user = User::findOrFail($user_id);
            $list_id = $user->lists()->first()->id;
            if(!array_key_exists('number',(array)$data)) return response(['message'=>'Number is required'],400);
            $phone = $data->number;
            $contact = Contact::query()->where('contact_phone_number',$phone)->where('contact_list_id',$list_id)->first();
            if($contact) $contact->delete();
            else return response('Contact Not Found',400);
            DB::commit();
            return response(['message'=>'Deleted'],200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response('Error While Deleting : '. $th,400);
        }
    }

}
