<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
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

    public function children()
    {
        return $this->hasMany($this, 'parent_id', 'id');
    }
    
    public function properties() {
		return $this->belongsToMany('App\Models\Property');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product');
    }

    public function seo()
    {
        return $this->morphOne('App\Models\Seo', 'seoable');
    }

    
    public function websites()
    {
        return $this->morphToMany('App\Models\Website', 'websiteable')->whereNull('websites.deleted_at');
    }
}
