<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded = ['id'];

    protected $hidden = ['code'];

    public function user(){
        return $this->owner();
    }

    public function owner(){
        return $this->belongsTo('App\User','owner_user_id');
    }

    public function holder(){
        return $this->belongsTo('App\User','holder_user_id');
    }

    public function transfers(){
        return $this->hasMany('App\Transfer');
    }

    public function transfered_users(){
        return Transfer::where('to_user_id','=',$this->user_id);
    }
}
