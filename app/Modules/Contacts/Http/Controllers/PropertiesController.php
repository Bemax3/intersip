<?php

namespace App\Modules\Contacts\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Contacts\Models\Contact;
use App\Modules\Contacts\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PropertiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $list_id = ListsController::getCurrentList($request);    
        return Inertia::render(
            'Contacts/Properties/ContactProperties',
            [
                'properties' => Property::query()->where("contact_list_id",$list_id)->get(),
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
            'property_name' => ['required']
        ]);   
        $list_id = ListsController::getCurrentList($request);
        try {
            DB::beginTransaction();
            $newProp = Property::create([
                'property_name' => $request->property_name,
                'property_description' => $request->property_description,
                'property_showing' => $request->property_showing,
                'contact_list_id' => $list_id,
                'created_by' => $request->user()->id
            ]);
            $existing_contacts = Contact::query()->where('contact_list_id',$list_id)->withTrashed()->get();
            foreach ($existing_contacts as $key => $contact) {
                $contact->properties()->attach($newProp->id,['value'=> '']);
            }
            DB::commit();
            return redirect()->route('contacts.list.properties',$list_id)->with('message',['body' => 'Property Created Successfully','type'=>'alert-success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('contacts.list.properties',$list_id)->with('message',['body' => 'Error While Creating Property','type'=>'alert-danger']);
        }


    }

    /**
     * Display the Trash.
     *
     * @return \Illuminate\Http\Response
     */
    public function showTrash(Request $request)
    {
        
        $list_id = ListsController::getCurrentList($request);
        return Inertia::render(
            'Contacts/Properties/Trash',
            [
                'properties' => Property::query()->onlyTrashed()->where("contact_list_id",$list_id)->get(),
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function retrieve(Request $request)
    {
        $this->validate($request,[
            'property_id' => ['required']
        ]);
        $list_id = ListsController::getCurrentList($request);
        try {
            DB::beginTransaction();
            Property::query()->onlyTrashed()->find($request->property_id)->restore();
            DB::commit();
            return redirect()->route('contacts.list.properties',$list_id)->with('message',['body' => 'Property Restored Successfully','type'=>'alert-success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('contacts.list.properties',$list_id)->with('message',['body' => 'Error While Restoring Property','type'=>'alert-danger']); 
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
            'property_name' => ['required'],
            'property_id' => ['required']
        ]);
        $list_id = ListsController::getCurrentList($request);
        try {
            DB::beginTransaction();
            $property = Property::find($request->property_id);
            $property->property_name = $request->property_name;
            $property->property_description = $request->property_description;
            $property->property_showing = $request->property_showing;
            $property->save();
            DB::commit();
            return redirect()->route('contacts.list.properties',$list_id)->with('message',['body' => 'Property Updated Successfully','type'=>'alert-success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('contacts.list.properties',$list_id)->with('message',['body' => 'Error While Updating Property','type'=>'alert-danger']); 
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        
        $this->validate($request,[
            'property_id' => ['required']
        ]);
        try {
            DB::beginTransaction();
            if($request->trash) {
                Property::find($request->property_id)->delete();
                DB::commit();
                return redirect()->route('contacts.list.properties')->with('message',['body' => 'Property Trashed Successfully','type'=>'alert-success']);
            }else {
                Property::query()->onlyTrashed()->find($request->property_id)->forceDelete();
                DB::commit();
                return redirect()->route('contacts.list.properties.trash')->with('message',['body' => 'Property Trashed Successfully','type'=>'alert-success']);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('contacts.list.properties')->with('message',['body' => 'Error While Trashing Property','type'=>'alert-danger']); 
        }
    }
}
