<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    //
    public function seoable()
    {
        return $this->morphTo();
    }
}
