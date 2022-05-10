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
        if($request->has('group_id')) $request->session()->put('current_contact_group_id',$request->group_id);
        
        $group_id = GroupsController::getCurrentGroup($request);
        if(!Group::query()->where('id',$group_id)->exists()) return redirect()->route('contacts.list.groups')->with('message',['body' => 'Error Group Doesn\'t Exist','type'=>'alert-danger']);
        $list_id = ListsController::getCurrentList($request);
        if(!ContactList::query()->where('id',$list_id)->exists()) return redirect()->route('contacts.lists')->with('message',['body' => 'Error List Doesn\'t Exist','type'=>'alert-danger']);
        
        $group = Group::query()->where('id',$group_id)->first();   
        $pagination = ContactsController::getPagination($request);
        return Inertia::render('Contacts/Groups/Group/Group',
        [
            'contacts' => $group->contacts()->with('country')->paginate($pagination),
            'pagination' => $pagination,
            'all' => Contact::query()->where('contact_list_id',$list_id)->whereDoesntHave('groups',function(EloquentBuilder $query) use ($group_id) {
                $query->where('group_id',$group_id);
            })->with('properties')->with('country')->get(),
            'group' => $group,
            'properties' => Property::query()->where('contact_list_id',$list_id)->where('property_showing',true)->get(),
            'countries' => Country::all()
        ]);
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
        $group_id = GroupsController::getCurrentGroup($request);
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
        
        $list_id = ListsController::getCurrentList($request);
        $group_id = GroupsController::getCurrentGroup($request);
        $keywords = $request->keywords;
        try {
            $result = Contact::query()
            ->where('contact_list_id',$list_id)
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
        
        $list_id = ListsController::getCurrentList($request);
        $group_id = GroupsController::getCurrentGroup($request);
        try {
            $keywords = $request->keywords;
            $result = Contact::query()
            ->where('contact_list_id',$list_id)
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
        $group_id = GroupsController::getCurrentGroup($request);
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
        $group_id = GroupsController::getCurrentGroup($request);
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
