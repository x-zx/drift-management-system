<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


class RecommendsController extends Controller
{
    public function index(){
       $recommends = \App\Recommend::valid()->get();
       echo $recommends->toJson();
    }

    public function create(){
        
    }

    public function update(){

    }

    public function store(){
        
    }


}
