<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder {

    public function run() {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // create permissions
        Permission::create([
            'name' => 'manage.auth.settings',
            'description' => 'Update Authentication Settings.',
            'display_name' => 'Manage Authentication Settings',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'manage.config.settings',
            'description' => 'Manage Site enviroment keyValue',
            'display_name' => 'Manage enviroment keyValue',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'manage.general.settings',
            'description' => 'Update General System Settings',
            'display_name' => 'Manage General Settings',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'manage.permissions',
            'description' => 'Manage role permissions.',
            'display_name' => 'Manage Permissions',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'manage.roles',
            'description' => 'Manage system roles.',
            'display_name' => 'Manage Roles',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'manage.users',
            'description' => 'Manage users and their sessions.',
            'display_name' => 'Manage Users',
            'guard_name' => 'web',
        ]);
        // create roles and assign created permissions

        $role = Role::create([
            'name' => 'administrator',
            'guard_name' => 'web',
            'display_name' => 'Super user',
            'description' => 'A administrator have all permission',
        ]);
        $role = Role::findOrFail(1); // role administrator
        $role->givePermissionTo(Permission::all());
        User::find(1)->assignRole($role);
        User::find(1)->syncPermissions(Permission::all());

        $role = Role::create([
            'name' => 'user',
            'guard_name' => 'web',
            'display_name' => 'Authenticated',
            'description' => 'Authenticated user',
        ]);
    }
}
