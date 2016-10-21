<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    protected $guarded = ['id'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function articles(){
        return $this->hasMany('Articl');
    }

    public function items(){
        return $this->hasMany('Item');
    }
}
