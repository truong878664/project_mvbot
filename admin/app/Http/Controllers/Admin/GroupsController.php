<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Groups;
use App\Models\Modules;
use Hash;
use Auth;
use DB;

class GroupsController extends Controller
{
    //
    // Display lists groups:
    public function index() {
        $users = User::all();
        $groups = Groups::all();

        return view('admin.groups.lists', compact('users', 'groups'));
    }

    // Add groups
    public function add(Request $request) {
        $request->validate(
            [
                'name' => 'required|unique:groups,name',
            ],
            [
                'name.required' => 'Name is empty',
                'name.unique' => 'Name is used'
            ]
        );

        $group = new Groups();
        $group->name = $request->name;
        $group->user_id = Auth::user()->id;
        $group->save();

        return redirect()->route('admin.groups.index')->with('msg', 'Add Group Successfully');
    }

    //Update groups
    public function edit(Groups $group, Request $request) {
        $group = Groups::where('id', $request->id)->get();

        $this->authorize('update', $group[0]);

        $request->validate(
            [
                'name' => 'required|unique:groups,name',
            ],
            [
                'name.required' => 'Name is empty',
                'name.unique' => 'Name is used'
            ]
        );

        $groupUpdate = [
            'id'          => $request->id,
            'name'        => $request->name,
            'user_id'     => Auth::user()->id
        ];

        Groups::where('id', $request->id)->update($groupUpdate);
        DB::commit();
        return redirect()->route('admin.groups.index')->with('msg', 'Update Group Successfully');
    }

    //Delete a group
    public function delete(Groups $group) {

        $userCount = $group->users->count();

        if ($userCount == 0) {
            Groups::destroy($group->id);
            return redirect()->route('admin.groups.index')->with('msg', 'Delete Group Successfully');
        }

        elseif ($userCount == 1) {
            return redirect()->route('admin.groups.index')->with('msg','There is '.$userCount.' people in group');
        }

        return redirect()->route('admin.groups.index')->with('msg','There are '.$userCount.' people in group');
    }

    // Permissions
    public function permission(Groups $group) {
        $modules = Modules::all();

        // Get value permissions for users
        $roleJson = $group->permissions;
        
        if (!empty($roleJson)) {
            $roleArr = json_decode($roleJson, true);
        }
        else {
            $roleArr = [];
        }

        $roleListArr = [
            'view' => 'View',
            'add' => 'Add',
            'edit' => 'Edit',
            'delete' => 'Delete'
        ];

        return view('admin.groups.permissions', compact('group', 'modules', 'roleListArr', 'roleArr'));
    }

    //Post permissions
    public function postPermission(Groups $group, Request $request) {
        if (!empty($request->role)) {
            $roleArr = $request->role;
        } else {
            $roleArr = [];
        }

        $roleJson = json_encode($roleArr);
        
        $group->permissions = $roleJson;
        $group->save();
        return back()->with('msg', 'Permission Successfully');
    }
}
