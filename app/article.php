<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function item(){
        return $this->belongsTo('App\Item');
    }

}
