<?php

namespace App\Modules\Contacts\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Modules\Contacts\Models\Contact;
use App\Modules\Contacts\Models\ContactGroup;
use App\Modules\Contacts\Models\ContactList;
use App\Modules\Contacts\Models\Group;
use App\Modules\Contacts\Models\Property;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class GroupContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->has('group_id') & !$request->session()->has("current_contact_group_id")) return redirect()->route('contacts.list.groups');
        if($request->has('group_id')) {
            $group_id = $request->group_id;
            $request->session()->put('current_contact_group_id',$group_id);
        }else {
            $group_id = $request->session()->get('current_contact_group_id');
        }
        if(!Group::query()->where('id',$group_id)->exists()) return redirect()->route('contacts.list.groups')->with('message',['body' => 'Error Group Doesn\'t Exist','type'=>'alert-danger']);
        
        if(!$request->session()->has("current_contact_list_id")) return redirect()->route('contacts.lists');
        else {
            $listId = $request->session()->get('current_contact_list_id');
        }
        if(!ContactList::query()->where('id',$listId)->exists()) return redirect()->route('contacts.lists')->with('message',['body' => 'Error List Doesn\'t Exist','type'=>'alert-danger']);
        $group = Group::query()->where('id',$group_id)->first();
           
        if(!$request->session()->has('pagination')) {
            $pagination = 10;
        }else {
            
            $pagination = $request->session()->get('pagination');
        }
        
        if($request->has('amount')) {
            $pagination = $request->amount;
            $request->session()->put('pagination',$pagination);
        } 
        return Inertia::render('Contacts/Groups/Group/Group',
        [
            'contacts' => $group->contacts()->with('country')->paginate($pagination),
            'pagination' => $pagination,
            'all' => Contact::query()->where('contact_list_id',$listId)->whereDoesntHave('groups',function(EloquentBuilder $query) use ($group_id) {
                $query->where('group_id',$group_id);
            })->with('properties')->with('country')->get(),
            'group' => $group,
            'properties' => Property::query()->where('contact_list_id',$listId)->where('property_showing',true)->whereHas('contacts',function(EloquentBuilder $query) {
                $query->where('contact_properties.value','!=',"NULL");})->get(),
            'countries' => Country::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'contacts' => ['required','array']
        ]);
        if($request->session()->has('current_contact_group_id')) {
            $group_id = $request->session()->get('current_contact_group_id');
        }else {
            return redirect()->route('contacts.list.groups')->with('message',['body' => 'Error Group Doesn\'t Exist','type'=>'alert-danger']);
        }

        try {
            DB::beginTransaction();
            foreach ($request->contacts as $key => $contact_id) {
                ContactGroup::create([
                    'group_id' => $group_id,
                    'contact_id' => $contact_id
                ]);
            }
            DB::commit();
            return redirect()->back()->with('message',['body' => 'Added Contacts to Group Successfully','type'=>'alert-success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('message',['body' => 'Error While Adding Contacts to Group','type'=>'alert-danger']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        if(!$request->session()->has("current_contact_list_id")) return redirect()->route('contacts.lists');
        else {
            $listId = $request->session()->get('current_contact_list_id');
        }
        if($request->session()->has('current_contact_group_id')) {
            $group_id = $request->session()->get('current_contact_group_id');
        }else {
            return redirect()->route('contacts.list.groups')->with('message',['body' => 'Error Group Doesn\'t Exist','type'=>'alert-danger']);
        }
        $keywords = $request->keywords;
        try {
            $result = Contact::query()
            ->where('contact_list_id',$listId)
            ->where('contact_phone_number','LIKE',"%{$keywords}%")
            ->orwhereHas('properties',function(EloquentBuilder $query) use ($keywords) {
                $query->where('contact_properties.value','LIKE',"%{$keywords}%");
            })
            ->whereDoesntHave('groups',function(EloquentBuilder $query) use ($group_id) {
                $query->where('group_id',$group_id);
            })->with('properties')
            ->with('country')
            ->get();
            return response()->json($result);
           
        } catch (\Throwable $th) {
            //throw $th;
        }

    }
    public function searchGroup(Request $request)
    {
        if(!$request->session()->has("current_contact_list_id")) return redirect()->route('contacts.lists');
        else {
            $listId = $request->session()->get('current_contact_list_id');
        }
        if($request->session()->has('current_contact_group_id')) {
            $group_id = $request->session()->get('current_contact_group_id');
        }else {
            return redirect()->route('contacts.list.groups')->with('message',['body' => 'Error Group Doesn\'t Exist','type'=>'alert-danger']);
        }
        $keywords = $request->keywords;
        try {
            $result = Contact::query()
            ->where('contact_list_id',$listId)
            ->where('contact_phone_number','LIKE',"%{$keywords}%")
            ->orwhereHas('properties',function(EloquentBuilder $query) use ($keywords) {
                $query->where('contact_properties.value','LIKE',"%{$keywords}%");
            })
            ->whereHas('groups',function(EloquentBuilder $query) use ($group_id) {
                $query->where('group_id',$group_id);
            })->with('properties')
            ->with('country')
            ->get();
            return response()->json($result);
           
        } catch (\Throwable $th) {
            //throw $th;
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        //
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
            'contact_id' => ['required']
        ]);
        if($request->session()->has('current_contact_group_id')) {
            $group_id = $request->session()->get('current_contact_group_id');
        }else {
            return redirect()->route('contacts.list.groups')->with('message',['body' => 'Error Group Doesn\'t Exist','type'=>'alert-danger']);
        }

        try {
            DB::beginTransaction();
            ContactGroup::query()->where('group_id',$group_id)->where('contact_id',$request->contact_id)->delete();
            DB::commit();
            return redirect()->back()->with('message',['body' => 'Removed Contact from Group Successfully','type'=>'alert-success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('message',['body' => 'Error While Removing Contact from Group','type'=>'alert-danger']);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroyMany(Request $request)
    {
        $this->validate($request,[
            'contacts_ids' => ['required']
        ]);

        if($request->session()->has('current_contact_group_id')) {
            $group_id = $request->session()->get('current_contact_group_id');
        }else {
            return redirect()->route('contacts.list.groups')->with('message',['body' => 'Error Group Doesn\'t Exist','type'=>'alert-danger']);
        }

        try {
            DB::beginTransaction();
            foreach ($request->contacts_ids as $key => $contact_id) {
                ContactGroup::query()->where('group_id',$group_id)->where('contact_id',$contact_id)->delete();
            }
            DB::commit();
            return redirect()->back()->with('message',['body' => 'Removed Contacts from Group Successfully','type'=>'alert-success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('message',['body' => 'Error While Removing Contacts from Group','type'=>'alert-danger']);
        }
    }
}
