<?php

namespace App\Http\Controllers\Admin;

use Validator;
use App\Models\Role;
use App\Models\Permission;
use App\Models\SessionData;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller {
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct() {

    $this->middleware('auth');
    $this->middleware(['role_or_permission:administrator|manage.users']);

  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request) {

    $search = $request->input('search');
    $users  = User::search($search)->simplePaginate(20);

    return view('admin.users.index', compact('users', 'search'));

  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create() {

    $roles = Role::get()->pluck('name', 'id');

    return view('admin.users.create', compact('roles'));

  }

  /**
   * Store a newly created User in storage.
   *
   * @param  \App\Http\Requests\Admin\StoreUsersRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreUsersRequest $request) {

    $user = User::create([
        'username'   => $request->input('username'),
        'first_name' => $request->input('first_name'),
        'last_name'  => $request->input('last_name'),
        'email'      => $request->input('email'),
        'password'   => bcrypt($request->input('password')),
        ]);

    if (Auth::user()->hasPermissionTo('manage.roles') || ($user->id == 1)) {
        $roles = $request->input('roles') ? $request->input('roles') : [];
        $user->assignRole($roles);
    }

    return redirect()->back()->with('success', 'User successfully added !');

  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id) {

      $user = User::findOrFail($id);

      return view('admin.users.show', compact('user'));

  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id) {

    $user        = User::findOrFail($id);
    $roles       = Role::get()->all();
    // dd($roles);
    $permissions = Permission::get()->all();

    return view('admin.users.edit', compact('permissions', 'roles', 'user' ));

  }

  /**
   * Update User in storage.
   *
   * @param  \App\Http\Requests\UpdateUsersRequest  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateUsersRequest $request, $id) {

    $user_id    = session()->get('user_id');
    $user       = User::findOrFail($user_id);
    $permission = $request->input('permission') ?
                  $request->input('permission') : [];
    $roles      = $request->input('roles') ? $request->input('roles') : [];

    if ( Auth::user()->hasPermissionTo('manage.users', 'web') || ($user->id == 1)) {
        $data = $request->all();
        if ($id == 1) {
            $request->merge(['active' => 1]);
        }
        $user->update($request->filled('password') ?
        $data :  $request->except(['password']));
    }

    if (Auth::user()->hasPermissionTo('manage.roles', 'web') || ($user->id == 1)) {

        if ($user->id == 1) {
            if ( ! in_array('administrator', $roles) ) {
                array_push($roles, 'administrator');
            }
        }

  		$user->syncRoles($roles);

    }

  if (Auth::user()->hasPermissionTo('manage.permissions', 'web') || ($user->id == 1)) {

    if ($user->id == 1) {
        $permission =  Permission::all()->pluck('id');
    }

    $user->syncPermissions($permission);
  }

    return redirect()->back()->with('success', 'User successfully Updated !');

  }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

      $user = User::findOrFail($id);
      if($user->id == 1){
          return back()->with('message', 'You cant delete user with ID of 1');
      }
      $user->delete();

      return back()->with('success', 'User successfully removed !');

    }


    public function storeAvatar(Request $request) {

      $user_id = session()->get('user_id');
      $user    = User::findOrFail($user_id);
      $user->addMedia($request->avatar)->toMediaCollection('avatar');

      return redirect()->back()
                              ->with('success', 'Avatar successfully uploaded');

    }


    public function session($id) {
      $user = User::findOrFail($id);
      $sessionData =SessionData::where('user_id', '=', $id)->get();

      return view('admin.users.sessions', compact('user', 'sessionData'));

    }

    public function invalidateSession($id, $sessionid) {

      $sessionData = SessionData::findOrFail($sessionid);
      $sessionData->delete();
      Session::flush();

      return back()->with('success', 'Session invalidated successfully');

    }
}
