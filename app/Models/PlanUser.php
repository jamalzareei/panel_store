<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class PlanUser extends Model
{
    protected $guarded =[];

    /**
     * Get the user that owns the PlanUser
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Get the user that owns the PlanUser
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
