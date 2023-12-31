<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
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
    public function image()
    {
        return $this->morphOne('App\Models\Image', 'imageable')->where('default_use', 'MAIN')->orderBy('id', 'desc');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
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

    public function branches()
    {
        return $this->hasMany('App\Models\SellerBranch');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function setting()
    {
        return $this->hasOne('App\Models\Setting');
    }

    public function socials()
    {
        return $this->hasMany('App\Models\SellerSocial');
    }

    public function finances()
    {
        return $this->hasMany('App\Models\Finance');
    }
    
    public function seo()
    {
        return $this->morphOne('App\Models\Seo', 'seoable');
    }
    
    public function websites()
    {
        return $this->morphToMany('App\Models\Website', 'websiteable')->whereNull('websites.deleted_at');
    }

    /**
     * The sells that belong to the Seller
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sells()
    {
        return $this->belongsToMany(SellType::class, 'sell_type_seller', 'seller_id', 'sell_type_id');
    }
    
    /**
     * The paies that belong to the Seller
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function paies()
    {
        return $this->belongsToMany(PayType::class, 'pay_type_seller', 'seller_id', 'pay_type_id');
    }
}
