<?php

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes(['verify' => true]);
Route::get('/', 'HomeController@index')->name('home');

Route::prefix('admin')->group(function () {
    Route::post('/permission/sync_Roles/', 'Admin\PermissionsController@sync_Roles')->name('sync_Roles');
    Route::resource('/permission', 'Admin\PermissionsController')->except('show');
    Route::resource('/roles', 'Admin\RolesController')->except('show');
    Route::match(['get', 'post'], '/users/{id}/session', 'Admin\UsersController@session')->name('users.session');
    Route::delete('/users/{id}/session/{sessionid}/invalidate','Admin\UsersController@invalidateSession')->name('users.invalidateSession');
    Route::post('/users/upload/', 'Admin\UsersController@storeAvatar')->name('users.storeAvatar');
    Route::resource('/users', 'Admin\UsersController');
});
Route::prefix('user')->group(function () {
    Route::get('/profile', 'User\UserProfileController@edit')->name('profile.edit');
    Route::post('/profile', 'User\UserProfileController@update')->name('profile.update');#->middleware('verified');
    Route::post('/profile/upload', 'User\UserProfileController@storeAvatar')->name('profile.upload');
});

Route::prefix('settings')->group(function () {
    Route::match(['get', 'post'], '/', 'Admin\SettingsController@general')->name('settings.general');
    Route::match(['get', 'post'], '/auth', 'Admin\SettingsController@authRegistration')->name('settings.authRegistration');
    Route::post('/auth/registration/captcha/enable', 'Admin\SettingsController@EnableRecaptcha')->name('settings.enableRecaptcha');
    Route::post('/auth/registration/captcha/disable', 'Admin\SettingsController@DisableRecaptcha')->name('settings.disableRecaptcha');
});
