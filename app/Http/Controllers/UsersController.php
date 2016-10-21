<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class UsersController extends Controller
{
    public function index(){
        $users =  \App\User;
        dd($users);
    }

    public function create(){

    }

    public function store(){
        
    }


}
