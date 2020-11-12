<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    //
    protected $guarded = [];

    public function priceproperties()
    {
        return $this->hasMany('App\Models\PriceProperty', 'price_id', 'id');
    }

    public function currency()
    {
        return $this->belongsTo('App\Models\Currency');
    }
}
