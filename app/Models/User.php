<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\File;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Hash;
use Cache;

class User extends Authenticatable implements MustVerifyEmail, HasMedia {
    use Notifiable, HasRoles, HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'last_name','first_name', 'email', 'password', 'username', 'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Hash password
     * @param $input
     */
    public function setPasswordAttribute($input) {
        $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
    }

    public function role(){
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function getFullNameAttribute() {
         return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }
    // search user by username, first_name, last_name, email
     public function scopeSearch($query, $search) {
         return $query->where('username', 'like', '%'.$search.'%')
                        ->orWhere('first_name', 'like', '%'.$search.'%')
                        ->orWhere('email', 'like', '%'.$search.'%')
                        ->orWhere('last_name', 'like', '%'.$search.'%');
     }

     // check if user is online
     public function isOnline() {
         return Cache::has('user-is-online-' . $this->id);
     }

    public function registerMediaCollections() {
        $this->addMediaCollection('avatar')->singleFile();
        $this->addMediaCollection('avatar')
            ->acceptsFile(function (File $file) {
            return $file->mimeType === 'image/jpeg';
        });
        $this->addMediaConversion('small')->width(90)->height(90);
        $this->addMediaConversion('thumb')->width(368)->height(232);

        }

}
