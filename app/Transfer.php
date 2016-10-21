<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $guarded = ['id'];

    public function users(){
        return $this->belongsToMany('User','form_user_id','to_user_id');
    }

    public function item(){
        return $this->belongsTo('Item');
    }
}
