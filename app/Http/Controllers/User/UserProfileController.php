<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateUsersRequest;
use App\Models\User;
use App\Models\Permission;
use Spatie\Permission\Models\Role;
use Auth;

class UserProfileController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}


	public function edit() {
		$user_id  = Auth::user()->id;
		$user 	  = User::findOrFail($user_id);
		$roles 	  = Role::get()->pluck('name', 'id');
    	$userRole = $user->roles->pluck('name','id')->all();

		return view('user.profile.edit', compact('user', 'roles', 'userRole'));

	}

	public function update(UpdateUsersRequest $request) {
		$user_id  = Auth::id();
		$user 	  = User::findOrFail($user_id);
		$data	    = $request->except(['password', 'password_confirmation']);
		if ($request->filled('password')) {
			$data = $request->all();
		}
		$user->update($data);
		if ($user->hasPermissionTo('manage.roles')) {
			$roles = $request->input('roles') ? $request->input('roles') : [];
			$user->syncRoles($roles);
		}
		return redirect('/user/profile')->with('success', 'Profile successfully Updated !');
	}

	public function storeAvatar(Request $request) {
		$user = auth()->user();
		$user->addMedia($request->avatar)->toMediaCollection('avatar');
		return redirect()->back()->with('success', 'Avatar successfully uploaded');
	}
}
