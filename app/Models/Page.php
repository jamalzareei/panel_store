<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    ////
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

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function seo()
    {
        return $this->morphOne('App\Models\Seo', 'seoable');
    }
    
    public function image()
    {
        return $this->morphOne('App\Models\Image', 'imageable')->where('default_use', 'MAIN')->orderBy('id', 'desc');
    }
}
