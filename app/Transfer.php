<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $guarded = ['id'];

    public function item(){
        return $this->belongsTo('App\Item');
    }

    public function from_user(){
        return $this->belongsTo('App\User','form_user_id');
    }

    public function to_user(){
        return $this->belongsTo()('App\User','to_user_id');
    }

}
