<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Star\Permission\Models\Role;
use Star\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;

    protected $fillable = [
        'name', 'email', 'password','mobile'
    ];

    // *
    //  * The attributes that should be hidden for arrays. 
    //  *
    //  * @var array
     
    protected $hidden = [
        'password', 'remember_token',
    ];

    // public function getTestAttribute($test)
    // {
    //     return new Test($test);
    // }

    public function wxmps()
    {
        return $this->belongsToMany(Wxmp::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
