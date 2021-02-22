<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class TicketMessage extends Model
{
    protected $guarded = [];
    
    /**
     * Get the ticket that owns the TicketMessage
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
