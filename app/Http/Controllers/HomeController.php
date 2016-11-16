<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


class HomeController extends Controller
{
    public function getIndex(){
    	//$id = 1;//session('user_id');
        //$recommends = \App\Recommend::latest()->limit(5)->get();
        //$articles = \App\Article::where(['class'=>'notice'])->latest()->limit(5)->get();
        //$user = \App\User::find($id);
        return view('index',compact([]));
    }

    public function getList(){
    	$recommends = \App\Recommend::latest()->limit(5)->get();
    	$articles = \App\Article::where(['class'=>'notice'])->latest()->limit(5)->get();
    	echo json_encode(['recommends'=>$recommends , 'articles'=>$articles]);
    }

    public function getClasses(){
    	$class_list = \App\Setting::where(['name'=>'class_list'])->first();
    	$classes = @json_decode($class_list->content, true);
    	if(!$classes){
    		$classes = [['code'=>'000000', 'name'=>'数据格式错误']];
    	}
    	echo @json_encode($classes);
    }

}
