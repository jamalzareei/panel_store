<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerBranch extends Model
{
    //
    protected $guarded = [];
    
    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }
    public function state()
    {
        return $this->belongsTo('App\Models\State');
    }
    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function seller()
    {
        return $this->belongsTo('App\Models\Seller');
    }
}
