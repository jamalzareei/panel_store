<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $guarded = [];

    public function sender()
    {
        return $this->belongsTo('App\User', 'user_sender_id', 'id');
    }

    public function receiver()
    {
        return $this->belongsTo('App\User', 'user_receiver_id', 'id');
    }

    public function read()
    {
        return $this->belongsToMany('App\User', 'message_user', 'message_id', 'user_id')->where('user_id', auth()->id())->select('message_id','user_id');
    }
    public function readAttach()
    {
        return $this->belongsToMany('App\User', 'message_user');//->where('user_id', auth()->id())->select('message_id','user_id');
    }
}
