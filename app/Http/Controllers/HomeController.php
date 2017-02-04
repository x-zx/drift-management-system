<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


class HomeController extends Controller
{
    public function getIndex(Request $request){
        $banner_src = \App\Setting::where(['name'=>'banner_src'])->first()->content;
        //$banner_url = \App\Setting::where(['name'=>'banner_url'])->first()->content;
        $setting = \App\Setting::where(['name'=>'class_name'])->first();
        $classes = json_decode($setting->content,true);
        $openid = $request->session()->get('openid');
        if(empty($openid)){
        	header("location:wechat/oauth");
        	exit();
        }else{
        	return view('index',compact(['classes','banner_src','banner_url','openid']));
        }
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
