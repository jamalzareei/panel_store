<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceProperty extends Model
{
    //
    protected $guarded = [];

    public function property()
    {
        return $this->belongsTo('App\Models\Property');
    }
}
