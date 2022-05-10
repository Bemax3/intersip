<?php

namespace App\Modules\Contacts\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Modules\Contacts\Models\Contact;
use App\Modules\Contacts\Models\ContactList;
use App\Modules\Contacts\Models\ContactProperty;
use App\Modules\Contacts\Models\Property;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Rap2hpoutre\FastExcel\FastExcel;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
       
        if($request->session()->has('current_contact_list_id')) $list_id = $request->session()->get('current_contact_list_id');    
        else {
            $list_id = $request->user()->lists()->first()->id;
            $request->session()->put('current_contact_list_id',$list_id);
        }
        if(!ContactList::query()->where('id',$list_id)->exists()) return redirect()->route('contacts.lists')->with('message',['body' => 'Error List Doesn\'t Exist','type'=>'alert-danger']); 
        $pagination = $this->getPagination($request);
        return Inertia::render(
            'Contacts/Contacts/Contacts',
            [
                'contacts' => Contact::query()->where('contact_list_id',$list_id)->with('country')->with('properties')->paginate($pagination),
                'pagination' => $pagination,
                'properties' => Property::query()
                    ->where('contact_list_id',$list_id)
                    ->where('property_showing',true)
                    ->get(),
                'countries' => Country::all(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'number' => ['required','numeric']
        ]);

        try {
            DB::beginTransaction();
            $list_id = ListsController::getCurrentList($request);
            $code = $request->code;
            str_replace('+','',$code);
            $phone = $code . $request->number;
            $phoneExist = Contact::query()->where('contact_list_id',$list_id)->where('contact_phone_number',$phone)->first();
            if(!$phoneExist) {   
                $new_contact = ContactList::find($list_id)->contacts()->create([
                    'country_id' => $request->country,
                    'contact_phone_number' => $phone
                ]);
                foreach ($request->fields as $key => $property) {
                    $new_contact->properties()->attach($property['id'],['value'=>$property['deleted_at']]);
                }
                
                $new_contact->save();
            } else {
                $old_contact = Contact::query()->where('contact_list_id',$list_id)->where('contact_phone_number',$phone)->first();
                if(!$old_contact) return redirect()->route('contacts.list.contacts')->with('message',['body' => 'Contact Exists and is trashed !','type'=>'alert-danger']);
                foreach ($request->fields as $key => $property) {
                    if(ContactProperty::query()->where('contact_id',$old_contact->id)->where('property_id',$property['id'])->exists())
                        $old_contact->properties()->updateExistingPivot($property['id'],['value'=>$property['deleted_at']]);
                    else
                        $old_contact->properties()->attach($property['id'],['value'=>$property['deleted_at']]);
                }
            }
            DB::commit();
            return redirect()->route('contacts.list.contacts')->with('message',['body' => 'Contact Created Successfully','type'=>'alert-success']);
        } catch (\Exception $th) {
            return redirect()->route('contacts.list.contacts')->with('message',['body' => 'Error While Creating Contact','type'=>'alert-danger']); 
            DB::rollBack();
        }
    }
    

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showTrash(Request $request)
    {
        $list_id = ListsController::getCurrentList($request);
        $pagination = $this->getPagination($request);
        return Inertia::render(
            'Contacts/Contacts/Trash',
            [
                'contacts' => Contact::query()->onlyTrashed()->where("contact_list_id",$list_id)->with('country')->with('properties')->paginate($pagination),
                'pagination' => $pagination,
                'properties' => Property::query()->where('contact_list_id',$list_id)->where('property_showing',true)->whereHas('contacts',function(EloquentBuilder $query) {
                    $query->where('contact_properties.value','!=',"NULL");})->get()
            ]
        );
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        try {
            $list_id = ListsController::getCurrentList($request);
            $keywords = $request->keywords;
            $result = Contact::query()
            ->where('contact_phone_number','LIKE',"%{$keywords}%")
            ->orwhereHas('properties',function(EloquentBuilder $query) use ($keywords) {
                $query->where('contact_properties.value','LIKE',"%{$keywords}%");
            })
            ->where('contact_list_id',$list_id)
            ->with('country')
            ->with('properties')->get();
            return response()->json($result);
            
        } catch (\Throwable $th) {
            
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchTrash(Request $request)
    {
        
        try {
            $list_id = ListsController::getCurrentList($request);
            $keywords = $request->keywords;
            $result = 
            Contact::query()
            ->where('contact_list_id',$list_id)
            ->where('contact_phone_number','LIKE',"%{$keywords}%")
            ->orwhereHas('properties',function(EloquentBuilder $query) use ($keywords) {
                $query->where('contact_properties.value','LIKE',"%{$keywords}%");
            })
            ->onlyTrashed()
            ->with('country')
            ->with('properties')->get();
            return response()->json($result);
            
        } catch (\Throwable $th) {
            
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function retrieve(Request $request)
    {
        $this->validate($request,[
            'contact_id' => ['required']
        ]);
        try {
            DB::beginTransaction();
            $contact = Contact::query()->onlyTrashed()->find($request->contact_id);
            $list_id = ListsController::getCurrentList($request);
            if(Contact::query()->where('contact_phone_number',$contact->contact_phone_number)->where('contact_list_id',$list_id)->exists()) {
                return redirect()->route('contacts.list.contacts')->with('message',['body' => 'Error While Restoring Contact: Number Already Exists','type'=>'alert-danger']); 
            }
            $contact->restore();
            DB::commit();
            return redirect()->route('contacts.list.contacts.trash')->with('message',['body' => 'Contact Restored Successfully','type'=>'alert-success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('contacts.list.contacts.trash')->with('message',['body' => 'Error While Restoring Contact','type'=>'alert-danger']); 
        }
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function retrieveMany(Request $request)
    {
        $this->validate($request,[
            'contacts_ids' => ['required']
        ]);
        try {
            DB::beginTransaction();
            $list_id = ListsController::getCurrentList($request);
            foreach ($request->contacts_ids as $key => $contact_id) {
                $contact = Contact::query()->onlyTrashed()->find($contact_id);
                if(Contact::query()->where('contact_phone_number',$contact->contact_phone_number)->where('contact_list_id',$list_id)->exists()) {
                    continue;
                }
                $contact->restore();
            }
            DB::commit();
            return redirect()->route('contacts.list.contacts.trash')->with('message',['body' => 'Contacts Restored Successfully','type'=>'alert-success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('contacts.list.contacts.trash')->with('message',['body' => 'Error While Restoring Contacts','type'=>'alert-danger']); 
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request,[
            'number' => ['required','numeric']
        ]);

        try {
            DB::beginTransaction();
            $contact = Contact::find($request->contact_id);
            $phone = $request->code . $request->number;
            if($contact->contact_phone_number !== $phone) {
                $list_id =ListsController::getCurrentList($request);
                $phoneExist = Contact::query()->where('contact_list_id',$list_id)->where('contact_phone_number',$phone)->first();
                if(!$phoneExist) {   
                    $contact->contact_phone_number = $phone;
                    $contact->country_id = $request->country;
                }
                else 
                    return redirect()->back()->with('message',['body' => 'Error While Updating Contact : New Phone Already Exists !','type'=>'alert-danger']);
                
            }
            foreach ($request->fields as $key => $property) {
                if(ContactProperty::query()->where('contact_id',$contact->id)->where('property_id',$property['id'])->exists())
                    $contact->properties()->updateExistingPivot($property['id'],['value'=>$property['pivot']['value']]);
                else
                    $contact->properties()->attach($property['id'],['value'=>$property['pivot']['value']]);
            }
            $contact->save();
            DB::commit();
            return redirect()->back()->with('message',['body' => 'Contact Updated Successfully','type'=>'alert-success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('message',['body' => 'Error While Updating Contact','type'=>'alert-danger']); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
                
        $this->validate($request,[
            'contact_id' => ['required']
        ]);
        try {
            DB::beginTransaction();
            if($request->trash) {
                Contact::find($request->contact_id)->delete();
                DB::commit();
                return redirect()->route('contacts.list.contacts')->with('message',['body' => 'Contact Trashed Successfully','type'=>'alert-success']);
            }else {
                Contact::query()->onlyTrashed()->find($request->contact_id)->forceDelete();
                DB::commit();
                return redirect()->route('contacts.list.contacts')->with('message',['body' => 'Contact Deleted Successfully','type'=>'alert-success']);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('contacts.list.contacts')->with('message',['body' => 'Error While Trashing Contact','type'=>'alert-danger']); 
        }
    }
    /**
     * Remove the specified resources from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyMany(Request $request)
    {
        
                
        $this->validate($request,[
            'contacts_ids' => ['required']
        ]);
        try {
            DB::beginTransaction();
            if($request->trash) {
                foreach ($request->contacts_ids as $key => $contact_id) {
                    Contact::find($contact_id)->delete();
                }
                DB::commit();
                return redirect()->route('contacts.list.contacts')->with('message',['body' => 'Contacts Trashed Successfully','type'=>'alert-success']);
            }else {
                foreach ($request->contacts_ids as $key => $contact_id) {
                    Contact::query()->onlyTrashed()->find($contact_id)->forceDelete();
                }
                DB::commit();
                return redirect()->route('contacts.list.contacts.trash')->with('message',['body' => 'Contacts Deleted Successfully','type'=>'alert-success']);
            }
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            return redirect()->route('contacts.list.contacts')->with('message',['body' => 'Error While Trashing Contacts','type'=>'alert-danger']); 
        }
    }

    public function import(Request $request) {
        $file = $request->file('file');
        if ($file) {
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension(); //Get extension of uploaded file
            $tempPath = $file->getRealPath();
            $fileSize = $file->getSize(); //Get size of uploaded file in bytes
            
            //Check for file extension and size
            $this->checkUploadedFileProperties($extension, $fileSize);
            
            //Where uploaded file will be stored on the server 
            $location = 'uploads'; //Created an "uploads" folder for that
            
            // Upload file
            $file->move($location, $filename);
            
            // In case the uploaded file path is to be stored in the database 
            $filepath = public_path($location . "/" . $filename);

            $contacts = (new FastExcel())->startRow(4)->import($filepath);
            $fields = array_keys((array)$contacts[0]);
            array_shift($fields);
            array_pop($fields);
            $new_fields = array();
            $list_id = ListsController::getCurrentList($request);
            foreach ($fields as $key => $value) {
                if(!Property::query()->where('property_name',$value)->where('contact_list_id',$list_id)->exists()) {
                    array_push($new_fields,$value); 
                }
            }
            
            return redirect()->back()->with('contactsImport',["fields" => $new_fields,"filepath" =>$filepath]); 
            
        } else {
            return redirect()->back()->route('contacts.list.contacts')->with('message',['body' => 'Error While Uploading Contact','type'=>'alert-danger']);
        }
    }

    public function checkUploadedFileProperties($extension, $fileSize) {
        $valid_extension = array("csv", "xlsx"); //Only want csv and excel files
        $maxFileSize = 2097152; // Uploaded file size limit is 2mb
        if (in_array(strtolower($extension), $valid_extension)) {
            if ($fileSize <= $maxFileSize) {
            } else {
                return redirect()->route('contacts.list.contacts')->with('message',['body' => 'Error: No file was uploaded','type'=>'alert-danger']);
            }
        } else {
            return redirect()->route('contacts.list.contacts')->with('message',['body' => 'Error: Invalid File Extension','type'=>'alert-danger']);
            
        }
    }

    public function importPart2(Request $request) {
        $this->validate($request,[
            "filepath" => ['required'],
        ]);
        if(!$request->session()->has('current_contact_list_id')) {
            return redirect()->route('contacts.lists')->with('message',['body' => 'Error: Session Expired, Choose Contact List','type'=>'alert-danger']);
        }
        $contacts = (new FastExcel)->startRow(4)->import($request->filepath);
        $newContacts = array();
        for ($i=0; $i < count($contacts); $i++) { 
            $contact = (array)$contacts[$i]; 
            array_pop($contact);
            array_push($newContacts,$contact); 
        }
        $fields = array_keys((array)$contacts[0]);
        array_pop($fields);
        $contacts = array();
        for ($i=0; $i < count($newContacts); $i++) { 
            $contact = (array)$newContacts[$i]; 
            $keys = array_keys($contact);
            $newContact = array();
            for ($j=0; $j < count($keys); $j++) { 
                $newContact[$fields[$j]] = $contact[$keys[$j]];
            }
            array_push($contacts,$newContact); 
        }
        
        $new_fields = $request->fields;
        try {
            DB::beginTransaction();
            $list_id = ListsController::getCurrentList($request);
            if(count($new_fields) > 0) {
                foreach ($new_fields as $key => $field) {
                    $newProp = Property::create([
                        'property_name' => $field,
                        'contact_list_id' => $list_id,
                    ]);
                    $existing_contacts = Contact::query()->where('contact_list_id',$list_id)->withTrashed()->get();
                    foreach ($existing_contacts as $key => $contact) {
                        $contact->properties()->attach($newProp->id,['value'=> '']);
                    }
                }
            }
            
            foreach ($contacts as $key => $contact) {
                $keys = array_keys($contact);
                
                $phone = $contact[$keys[0]];
                $phone = str_replace(" ","",$phone);
                if(empty($phone)) return redirect()->back()->with('message',['body' => 'Error A contact is missing the Number!','type'=>'alert-danger']);             
                $phoneExist = Contact::query()->where('contact_list_id',$list_id)->where('contact_phone_number',$phone)->first();
                $country = $this->findCountry($phone);
                if(!$phoneExist) {   
                    $new_contact = ContactList::find($list_id)->contacts()->create([
                        'country_id' => $country->id,
                        'contact_phone_number' => $phone,
                    ]);
                    
                    for ($i=1; $i < count($keys); $i++) {
                        $property = Property::query()->where('property_name',$keys[$i])->where('contact_list_id',$list_id)->first();
                        $new_contact->properties()->attach($property->id,['value'=>$contact[$keys[$i]]]);
                    }

                    $new_contact->save();
                }else {
                    $old_contact = Contact::query()->where('contact_list_id',$list_id)->where('contact_phone_number',$phone)->first();
                    for ($i=1; $i < count($keys); $i++) {
                        $property = Property::query()->where('property_name',$keys[$i])->where('contact_list_id',$list_id)->first();
                        if(ContactProperty::query()->where('contact_id',$old_contact->id)->where('property_id',$property->id)->exists())
                            $old_contact->properties()->updateExistingPivot($property->id,['value'=>$contact[$keys[$i]]]);
                        else
                            $old_contact->properties()->attach($property->id,['value'=>$contact[$keys[$i]]]);
                    }
                    $old_contact->save();
                }
            }
            DB::commit();
            
            return redirect()->route('contacts.list.contacts')->with('message', ['body' => 'Imported Contacts Successfully !','type'=>'alert-success']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('contacts.list.contacts')->with('message',['body' => 'Error: Make sure Phone Numbers respect the right format !','type'=>'alert-danger']);
        }
        
    }
    

    public function findCountry($phone) {
        $country = new Country();
        for ($i=4; $i >= 1; $i--) { 
            try {
                $country = Country::where('settings_country_calling_code',substr($phone,0,$i))->get()->first();
                if($country !== null)
                    return $country;
                else 
                continue;
            } catch (\Exception $th) {
                continue;
            }
        }
        return $country;
    }

    public static function getPagination($request) {
        if(!$request->session()->has('pagination')) $pagination = 10;
        else $pagination = $request->session()->get('pagination');
        if($request->has('amount')) {
            $pagination = $request->amount;
            $request->session()->put('pagination',$pagination);
        } 
        return $pagination;
    }
    
}
