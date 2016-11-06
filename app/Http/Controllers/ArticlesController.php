<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


class ArticlesController extends Controller
{
    public function index(){
       $recommends = \App\Recommend::valid()->get();
       echo $recommends->toJson();
    }

    public function show($id){
        $article = \App\Article::find($id);
        echo $article->toJson();
    }
    
    
    public function create(){
        
    }

    public function update(){
        
    }

    public function store(){
        
    }


}
