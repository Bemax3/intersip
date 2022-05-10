<?php

namespace App\Modules\Contacts\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Contacts\Models\Group;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Inertia::render('Contacts/Groups/ContactGroups',[
            'groups' => $request->user()->contactGroups()->withCount('contacts')->get(),
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
            'group_name' => ['required']
        ]);

        try {
            DB::beginTransaction();
            $request->user()->contactGroups()->create([
                'group_name' => $request->group_name,
                'group_description' => $request->group_description,
            ]);
            DB::commit();
            return redirect()->back()->with('message',['body' => 'Group Created Successfully','type'=>'alert-success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('message',['body' => 'Error While Creating Group','type'=>'alert-danger']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showTrash(Request $request)
    {
        return Inertia::render(
            'Contacts/Groups/Trash',
            [
                'groups' => Group::query()->onlyTrashed()->where('user_id',$request->user()->id)->get()
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function retrieve(Request $request)
    {
        $this->validate($request,[
            'group_id' => ['required']
        ]);
        try {
            DB::beginTransaction();
            Group::query()->onlyTrashed()->find($request->group_id)->restore();
            DB::commit();
            return redirect()->back()->with('message',['body' => 'Group Restored Successfully','type'=>'alert-success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('message',['body' => 'Error While Restoring Group','type'=>'alert-danger']); 
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
            'group_id' => ['required'],
            'group_name' => ['required'],
        ]);

        try {
            DB::beginTransaction();
            $group = Group::find($request->group_id);
            $group->group_name = $request->group_name;
            $group->group_description = $request->group_description;
            $group->save();
            DB::commit();
            return redirect()->back()->with('message',['body' => 'Group Updated Successfully','type'=>'alert-success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('message',['body' => 'Error While Updating Group','type'=>'alert-danger']);
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
            'group_id' => 'required'
        ]);
        try {
            DB::beginTransaction();
            if($request->trash) Group::find($request->group_id)->delete();
            else Group::query()->onlyTrashed()->find($request->group_id)->forceDelete();
            DB::commit();
            return redirect()->back()->with('message',['body' => 'Group Trashed Successfully','type'=>'alert-success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            return redirect()->back()->with('message',['body' => 'Error While Trashing Group ','type'=>'alert-error']);
        }

    }

    public static function getCurrentGroup($request) {
        if(!$request->session()->has('current_contact_group_id')) return redirect()->route('contacts.list.groups')->with('message',['body' => 'Error Group Doesn\'t Exist','type'=>'alert-danger']);
        return $request->session()->get('current_contact_group_id');
    }
}
