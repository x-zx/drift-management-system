<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recommend extends Model
{
    protected $guarded = ['id'];

    public function items(){
        return Item::where('name','like',"%{$this->name}%");
    }

    public function finished_users(){
        $items = Item::where('name','like',"%{$this->name}%");
        return $items->transfered_users;
    }

}
