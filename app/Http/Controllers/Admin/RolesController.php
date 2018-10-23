<?php

namespace App\Http\Controllers\Admin;

use DB;
use Session;
use Validator;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRolesRequest;
use App\Http\Requests\Admin\UpdateRolesRequest;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\Gate;

class RolesController extends Controller {
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct() {
      $this->middleware('auth');
      $this->middleware(['role_or_permission:administrator|manage.roles']);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index() {

      $roles = Role::withCount('users')->paginate(20);

      return view('admin.roles.index', compact('roles'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create() {

      $permissions = Permission::get()->pluck('name', 'name');

      return view('admin.roles.create', compact('permissions'));

  }

  /**
   * Store a newly created Role in storage.
   *
   * @param  \App\Http\Requests\StoreRolesRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreRolesRequest $request) {

    $role           = Role::create($request->except('permission'));
    $permissions    = $request->input('permission') ?
                      $request->input('permission') : [];

    $role->givePermissionTo($permissions);

    return redirect()->route('roles.index')
                      ->with('success', 'Roles Permission Successfully added');
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id) {

    $permissions = Permission::get()->pluck('name', 'name');
    $role = Role::findOrFail($id);

    return view('admin.roles.edit', compact('permissions', 'role'));

  }

  /**
   * Update Role in storage.
   *
   * @param  \App\Http\Requests\UpdateRolesRequest  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateRolesRequest $request, $id) {

    $role = Role::findOrFail($id);

    if($role->id == 1 or $role->id == 2) {

        $role->update($request->except(['permission', 'name']));

    }

    if ($role->id !== 1) {

      $role->update($request->except('permission'));
      $permissions = $request->input('permission') ?
                     $request->input('permission') : [];

      $role->syncPermissions($permissions);

    }

    return redirect()->route('roles.index')
                  ->with('success', 'Roles Permission Successfully updated');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id) {

    $role = Role::findOrFail($id);

    if(($role->id == 1) or ($role->id == 2)){

        return redirect()->back()
          ->with('message', 'Role '.ucfirst($role->name).' is default cant be delete !');
    }

    $role->delete();

    return back()->with('success', 'Roles Permission Successfully deleted !');

  }
}
