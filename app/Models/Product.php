<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
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
    
    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }

    public function seo()
    {
        return $this->morphOne('App\Models\Seo', 'seoable');
    }

    public function images()
    {
        return $this->morphMany('App\Models\Image', 'imageable')->whereNull('deleted_at');
    }

    public function price()
    {
        return $this->hasOne('App\Models\Price')
        ->select('prices.*', 'currencies.name as currency_name')
        ->leftJoin('currencies', 'currencies.id', 'prices.currency_id')
        ->whereNotNull('actived_at')->latest();
    }

    public function prices()
    {
        return $this->hasMany('App\Models\Price')
        ->select('prices.*', 'currencies.name as currency_name')
        ->leftJoin('currencies', 'currencies.id', 'prices.currency_id');
    }
}
