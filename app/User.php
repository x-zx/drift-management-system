<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    protected $guarded = ['id'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function articles(){
        return $this->hasMany('App\Article');
    }
    
    public function own_items(){
        return $this->hasMany('App\Item','owner_user_id');
    }

    public function hold_items(){
        return $this->hasMany('App\Item','holder_user_id');
    }

    public function transfers(){
        return $this->hasMany('App\Transfer','form_user_id','to_user_id');
    }

    public static function findOpenid($openid){
        return User::where('openid','=',$openid)->where('openid','<>','')->first();
    }

    public function setAgentAttribute($agent){
        $this->attributes['agent'] = $_SERVER['HTTP_USER_AGENT'];
    }

}
