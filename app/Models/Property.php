<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use Sluggable;
    //
    protected $guarded = [];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function propertyvalue()
    {
        return $this->hasOne('App\Models\PropertyValue');
    }
    
    public function seo()
    {
        return $this->morphOne('App\Models\Seo', 'seoable');
    }
}
