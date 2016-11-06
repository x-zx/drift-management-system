<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


class AdminController extends Controller
{
    public function getIndex(Request $request){
    	$admin = $request->session()->has('admin') ? $request->session()->get('admin') : false;
    	if($admin){
    		return redirect('/admin/items');
    	}else{
    		return redirect('/admin/login');
    	}
        
    }
    
    public function getLogin(Request $request){
    	return view('admin.login');
    }

    public function getLogout(Request $request){
    	$request->session()->forget('admin');
    	return redirect('/admin');
    }
   
   	public function postLogin(Request $request){
   		$access_user = \App\Setting::where(['name'=>'admin_username'])->first()->content;
   		$access_pass = \App\Setting::where(['name'=>'admin_password'])->first()->content;
   		$input = $request->input();

   		if($access_user==$input['user'] && $access_pass==$input['pass']){
   			$request->session()->put('admin',true);
   			return redirect('/admin');
   		}else{
   			return redirect('/admin/login');
   		}
   	}

   	public function getItems(Request $request){
   		//$input = $request->input();
   		//$page = $input['page'];
   		$items = \App\Item::latest()->paginate(10);

   		return view('admin.items',compact('items'));
   	}

   	public function getDelitem(Request $request){
   		$input = $request->input();
   		$item = \App\Item::find($input['id'])->first();
   		if($item)$item->delete();
   		return redirect()->back();
   	}


   	public function getArticle(Request $request){
   		$input = $request->input();
   		$article = \App\Article::where(['id'=>$input['id']])->first();
   		return view('admin.article',compact('article'));
   	}

   	public function getArticles(Request $request){
   		//$input = $request->input();
   		//$page = $input['page'];
   		$articles = \App\Article::orderBy('class', 'DESC')->latest()->paginate(15);

   		return view('admin.articles',compact('articles'));
   	}

   	public function getRecommends(Request $request){
   		//$input = $request->input();
   		$recommends = \App\Recommend::latest()->limit(100)->get();
   		//var_dump($recommends);
   		return view('admin.recommends',compact('recommends'));
   	}

   	public function postRecommends(Request $request){
   		$input = $request->input();
   		$recommend = new \App\Recommend;
   		$recommend->name = $input['name'];
   		$recommend->save();
   		return redirect()->back();
   	}

   	public function getDelrecommend(Request $request){
   		$input = $request->input();
   		$recommend = \App\Recommend::find($input['id'])->first();
   		if($recommend)$recommend->delete();
   		return redirect()->back();
   	}

   	public function getSettings(Request $request){
   		$settings = \App\Setting::all();
   		return view('admin.settings',compact('settings'));
   	}

   	public function postSettings(Request $request){
   		$input = $request->input();
   		foreach ($input as $key => $value) {
   			$setting = \App\Setting::where(['name'=>$key])->first();
   			if($setting){
   				$setting->content = $value;
   				$setting->save();
   			}
   		}
   		return redirect()->back();
   		return view('admin.settings',compact('settings'));   	}

   	public function getNewarticle(Request $request){
   		return view('admin.new_article');
   	}

   	public function postNewarticle(Request $request){
   		$input = $request->input();
   		$article = new \App\Article;
   		$article->title = $input['title'];
   		$article->user_id = 1;
   		$article->content = $input['content'];
   		$article->class = 'notice';
   		$article->save();
   		return redirect('/admin/articles');
   	}

   	public function getDelarticle(Request $request){
   		$input = $request->input();
   		$article = \App\Article::find($input['id'])->first();
   		if($article)$article->delete();
   		return redirect()->back();
   	}

   	public function getFinishedlist(Request $request){
   		$input = $request->input();
   		$recommend = \App\Recommend::find($input['id'])->first();
   		$users = $recommend->finished_users();

   		header("Content-type:text/csv");   
	    header("Content-Disposition:attachment;filename=". $recommend->name . '.csv');   
	    header('Cache-Control:must-revalidate,post-check=0,pre-check=0');   
	    header('Expires:0');   
	    header('Pragma:public');   

   		foreach ($users as $user) {
   			$data =  $user['id'] . "," . $user['name'] . "," . $user['class']. "\n";
   			$data = iconv('utf-8','gb2312',$data);
   			echo $data;
   		}
   	}
    
}
