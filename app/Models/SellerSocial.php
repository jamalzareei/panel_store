<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerSocial extends Model
{
    //
    protected $guarded = [];
    protected $table = 'seller_social';

    public function social()
    {
        return $this->belongsTo('App\Models\Social');
    }
}
