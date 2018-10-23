<?php

namespace App\Http\Controllers\Admin;

use Session;
use Validator;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use App\Http\Requests\Admin\StorePermissionsRequest;
use App\Http\Requests\Admin\UpdatePermissionsRequest;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\Gate;
use Illuminate\Support\Facades\Input;

class PermissionsController extends Controller {

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct() {
    $this->middleware('auth');
    $this->middleware(['role_or_permission:administrator|manage.permissions']);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index() {

    $permissions = Permission::paginate(20);
    $roles = Role::all();

    return view('admin.permission.index', compact('permissions', 'roles'));

  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create() {

      return view('admin.permission.create');

  }

  /**
   * Store a newly created Permission in storage.
   *
   * @param  \App\Http\Requests\StorePermissionsRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StorePermissionsRequest $request) {

    Permission::create(request([
        'name'          => 'name',
        'guard_name'    => 'guard_name',
        'description'   => 'description',
        'display_name'  => 'display_name',
    ]));

    $role = Role::findOrFail(1);
    $user = User::findOrFail(1);

    // automatically add new permission to role administrator
    // and user with id of 1

    $role->syncPermissions(Permission::all());
    $user->syncPermissions(Permission::all());
    return redirect()->route('permission.index')
                          ->with('success', 'Permission successfully created');
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id) {

    $permission = Permission::findorFail($id);

    return view('admin.permission.edit', compact('permission'));

  }

  /**
   * Update Permission in storage.
   *
   * @param  \App\Http\Requests\UpdatePermissionsRequest  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(UpdatePermissionsRequest $request, $id) {

    $permission = Permission::findOrFail($id);

    if ( ($permission->id)  >= 1 && ($permission->id <=6) ){

      $permission->update($request->except(['name']));

    }else{

      $permission->update(request([
        'name'          => 'name',
        'guard_name'    => 'guard_name',
        'display_name'  => 'display_name',
        'description'   => 'description',
      ]));

    }

    return redirect()->route('permission.index')
                          ->with('success', 'Permission successfully updated');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id) {

    $permission = Permission::findOrFail($id);

    if ( ($permission->id)  >= 1 && ($permission->id <=6) ){

        return redirect()->back()
                  ->with('message', 'Default Permission can\'t be  deleted !');
    }

    $permission->delete();

    return redirect()->route('permission.index')
                        ->with('success', 'Permission successfully deleted !');
  }


  public function sync_Roles(Request  $request) {

    $rolesPermission = Input::get('roles' , false);
    $roles = Role::get()->where('id', '!=', 1)->pluck('id');

    // if $request->input['roles'] empty
    // revoke all permission to role except administrator

    if ( ! $rolesPermission ) {
       foreach ( $roles as $role ) {
           Role::findOrFail($role)->revokePermissionTo(Permission::all());
       }
       return redirect()->route('permission.index')
                          ->with('success', 'Permission successfully updated');
    }

    foreach ( $roles as $role ) {

      if(!array_key_exists($role, $rolesPermission)) {

          Role::findOrFail($role)->revokePermissionTo(Permission::all());

      }else{

          Role::findOrFail($role)->syncPermissions($rolesPermission[$role]);

      }

    }

    return redirect()->back()
                        ->with('success', 'Permission successfully updated');

 }

}
