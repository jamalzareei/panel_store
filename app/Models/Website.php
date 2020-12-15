<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    //
    protected $guarded = [];

    public function categories()
    {
        return $this->morphedByMany('App\Models\Category', 'websiteable');
    }
}
