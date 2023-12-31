<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'name', 'email', 'password',
    // ];
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];

    protected $appends = [
        'full_name'
    ];

    public function roles() {
		return $this->belongsToMany('App\Models\Role');
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

    public function getFullNameAttribute() {
        return "{$this->firstname} {$this->lastname}";
    }

    public function image()
    {
        return $this->morphOne('App\Models\Image', 'imageable')->whereNull('deleted_at')->where('default_use', 'MAIN')->orderBy('id', 'desc');
    }

    public function seller()
    {
        return $this->hasOne('App\Models\Seller')->whereNull('deleted_at');
    }

    public function finances()
    {
        return $this->hasMany('App\Models\Finance')->whereNull('deleted_at');
    }

    public function readAttach()
    {
        return $this->belongsToMany('App\Models\Message');//->where('user_id', auth()->id())->select('message_id','user_id');
    }
}
