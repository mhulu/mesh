<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    protected $guarded = ['id'];

    protected $visible = ['id', 'name', 'deadline', 'icon'];

    public function wxmps()
    {
        return $this->belongsToMany(Wxmp::class);
    }
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}
