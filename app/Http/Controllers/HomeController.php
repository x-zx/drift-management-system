<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


class HomeController extends Controller
{
    public function getIndex(){
    	$id = 1;//session('user_id');
        $recommends = \App\Recommend::latest()->limit(5)->get();
        $articles = \App\Article::where(['class'=>'notice'])->latest()->limit(5)->get();
        $user = \App\User::find($id);
        return view('index',compact('recommends','articles','user'));
    //  
       
    //   echo $recommends->toJson();
    }

    public function getList(){
    	$recommends = \App\Recommend::select('id','name')->latest()->limit(5)->get();
    	$articles = \App\Article::where(['class'=>'notice'])->select('id','title')->latest()->limit(5)->get();
    	echo json_encode(['recommends'=>$recommends, 'articles'=>$articles]);
    }
    
    
}
