<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wxmp extends Model
{
    protected $guarded = ['id'];
    protected $hidden = ['pivot', 'created_at', 'updated_at'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_wxmp');
    }

    public function apps()
    {
        return $this->belongsToMany(App::class);
    }
}
