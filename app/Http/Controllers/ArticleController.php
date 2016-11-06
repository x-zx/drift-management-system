<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


class ArticleController extends Controller
{
    public function getIndex(){
        echo "Article";
        //$recommends = \App\Recommend::valid()->get();
        //return view('index',compact('recommends'));
    }
    
    public function getSearch(Request $request){

    }
    
    public function getId($id){
        $article = \App\Article::find($id);
        $user = \App\User::find($article->user_id);
        $article->user_name = $user->name;
        echo $article->toJson();
    }

    public function getUser($id){
        $articles = \App\User::find($id)->articles()->select('id','title')->get();
        echo $articles->toJson();
    }
    
    public function postPost(Request $request){
        $openid = $request->session()->has('openid') ? $request->session()->get('openid') : '';
        $input = $request->input();
        $article = new \App\Article;
        $user = \App\User::findOpenid($openid);
        if($user){
            $article->user_id = $user->id;
            $article->class = isset($input['class']) ? $input['class'] : 'note';
            $article->item_id = $input['item_id'];
            $article->title = $input['title'];
            $article->content = $input['content'];
            $article->save();
        }
        
    }
    
}
