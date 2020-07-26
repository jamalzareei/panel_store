<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    //
    protected $guarded = [''];

    
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }

    public function users()
    {
        return $this->hasManyThrough('App\User', 'App\Models\Role');
    }
}
