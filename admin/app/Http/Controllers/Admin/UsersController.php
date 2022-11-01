<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Groups;
use Hash;
use Auth;
use DB;

class UsersController extends Controller
{
    //Display users
    public function index() {
        $groups = Groups::all();

        $userId = Auth::user()->id;

        if (Auth::user()->user_id == $userId) {
            $users = User::all();
        } else {
            $users = User::where('user_id', $userId)->get();
        }

        return view('admin.users.lists', compact('users', 'groups'));
    }

    //Add users
    public function add(Request $request) {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'group_id' => ['required', function($attribute, $value, $fail){
                    if ($value == 0) {
                        $fail('Please Choose a Group');
                    }
                }]
            ],
            [
                'name.required' => 'Name is empty',
                'email.required' => 'Email is empty',
                'email.email' => 'Email is not choose fomart',
                'email.unique' => 'Email is used',
                'password.required' => 'Password is empty',
                'group_id.required' => 'Group id is empty'
            ]
        );

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->group_id = $request->group_id;
        $user->user_id = Auth::user()->id;
        $user->save();
        return redirect()->route('admin.users.index')->with('msg', 'Add User Successfully');
    }

    //Update user
    public function edit(User $user, Request $request) {
        $user = User::where('id', $request->id)->get();

        $this->authorize('update', $user[0]);

        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,'.$request->id,
                'group_id' => ['required', function($attribute, $value, $fail){
                    if ($value == 0) {
                        $fail('Please choose a group');
                    }
                }]
            ],
            [
                'name.required' => 'Name is empty',
                'email.required' => 'Email is empty',
                'email.email' => 'Email is not choose fomart',
                'email.unique' => 'Email is used',
                'group_id.required' => 'Group id is empty'
            ]
        );

        if (!empty($request->password)) {
            $newPassword = Hash::make($request->password);
        }

        $userUpdate = [
            'id'          => $request->id,
            'name'        => $request->name,
            'email'       => $request->email,
            'user_id'     => Auth::user()->id,
            'password'    => $newPassword,
            'group_id'    => $request->group_id,
        ];
    
        User::where('id', $request->id)->update($userUpdate);
        DB::commit();
        return redirect()->route('admin.users.index')->with('msg', 'Update User Successfully');
    }

    //Delete user
    public function delete(User $user) {
        $this->authorize('delete', $user);

        if (Auth::user()->id !== $user->id) {
            //Process delete user
            User::destroy($user->id);
            return redirect()->route('admin.users.index')->with('msg', 'Delete User Successfully');
        };

        return redirect()->route('admin.users.index')->with('msg', 'You can not delete user');
    }
}
