<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home'));
});


// Home > Users
Breadcrumbs::for('users', function ($trail) {
    $trail->parent('home');
    $trail->push('Users', route('users.index'));
});


// Home > Users > create
Breadcrumbs::for('user-create', function ($trail) {
    $trail->parent('home');
    $trail->push('users', route('users.index'));
    $trail->push('create', route('users.create'));
});

// Home > Users > edit
Breadcrumbs::for('user-edit', function ($trail, $id) {
	$user = App\Models\User::findOrFail($id);
    $trail->parent('home');
    $trail->push('users', route('users.index'));
    $trail->push('edit', route('users.edit', $user));
});

// Home > Users > id
Breadcrumbs::for('show-user', function ($trail, $id) {
	$user = App\Models\User::findOrFail($id);
    $trail->parent('home');
    $trail->push('users', route('users.index'));
    $trail->push("$user->email", route('users.index'));
});

// Home > Users > email >sessions
Breadcrumbs::for('user-session', function ($trail, $id) {
	$user = App\Models\User::findOrFail($id);
    $trail->parent('home');
    $trail->push('users', route('users.index'));
    $trail->push("$user->email", route('users.edit', $user->id));
    $trail->push('sessions');
});
// Home > Permission
Breadcrumbs::for('permission', function ($trail) {
    $trail->parent('home');
    $trail->push('Permission', route('permission.index'));
});

// Home > Permission > create
Breadcrumbs::for('permission-create', function ($trail) {
    $trail->parent('home');
    $trail->push('Permission', route('permission.index'));
    $trail->push('create', route('permission.create'));
});

// Home > Permission > edit
Breadcrumbs::for('permission-edit', function ($trail, $id) {
	$permission = App\Models\Permission::findOrFail($id);
    $trail->parent('home');
    $trail->push('Permission', route('permission.index'));
    $trail->push('edit', route('permission.edit' , $permission));
});

// Home > Role
Breadcrumbs::for('roles', function ($trail) {
    $trail->parent('home');
    $trail->push('Roles', route('roles.index'));
});


// Home > Role > create
Breadcrumbs::for('role-create', function ($trail) {
    $trail->parent('home');
    $trail->push('Role', route('roles.index'));
    $trail->push('create', route('roles.create'));
});

// Home > Role > edit
Breadcrumbs::for('role-edit', function ($trail, $id) {
	$role = App\Models\Role::findOrFail($id);
    $trail->parent('home');
    $trail->push('Role', route('roles.index'));
    $trail->push('edit', route('roles.edit' , $role));
});


// Home > Settings > Auth & Registration
Breadcrumbs::for('settings-authRegistration', function ($trail) {
    $trail->parent('home');
    $trail->push('Settings', route('settings.general'));
    $trail->push('Authentication', route('settings.authRegistration'));

});

// Home > Settings > Configuration
Breadcrumbs::for('settings-configuration', function ($trail) {
    $trail->parent('home');
    $trail->push('Settings', route('settings.general'));
    $trail->push('Configuration');

});

// Home > Settings > General
Breadcrumbs::for('settings-general', function ($trail) {
    $trail->parent('home');
    $trail->push('Settings', route('settings.general'));
    $trail->push('General', route('settings.general'));
});

// Home > MyProfile
Breadcrumbs::for('profile', function ($trail) {
    $trail->parent('home');
    $trail->push('MyProfile', route('profile.edit'));
});
 ?>
