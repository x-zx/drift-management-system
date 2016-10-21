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
        $user = \App\User::findOpenid('fd42a186aee358562d66dc063f7ebcd3');
        $r = new \App\Recommend;
        $r->name = "三体";
        $users = $r->finished_users;

        dd($users);
    }

    public function create(){
        
    }

    public function update(){

    }

    public function store(){
        
    }

}
