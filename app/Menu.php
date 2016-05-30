<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at', 'app_id', 'id'];

    public function app()
    {
        return $this->belongsTo('App\App');
    }

    public function childNodes()
    {
        return $this->hasMany('App\Menu', 'parent_id', 'id');
    }

    public function parentNode()
    {
        return $this->belongsTo('App\Menu', 'parent_id');
    }
}
