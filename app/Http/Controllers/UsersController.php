<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class UsersController extends Controller
{
    public function index(){
        // $users =  \App\User::all();
        // foreach($users as $user){
        //     echo $user->name;
        //     foreach($user->own_items as $item){
        //         echo $item->name;
        //     }
        //     //dd([$user->name, $user->own_items()]);
        // }
        //$user = \App\User::findOpenid('fd42a186aee358562d66dc063f7ebcd3');
        $r = \App\Recommend::find(1);
        //dd($r);
        $users = $r->finished_users();
        echo $users->toJson();
        //dd($users);
    }

    public function create(){
        
    }

    public function update(){

    }

    public function store(){
        
    }


}
