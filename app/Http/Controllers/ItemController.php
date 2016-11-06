<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


class ItemController extends Controller
{
    public function getIndex(){
        echo "Item";
        //$recommends = \App\Recommend::valid()->get();
        //return view('index',compact('recommends'));
    }
    
    public function getSearch(Request $request){
        $input = $request->input();

        if(empty($input['user_id'])){
            $items = \App\Item::where('name', 'LIKE', "%{$input['keywords']}%")->latest()->forPage($input['page'],10)->get();
        }else{
            $items = \App\Item::Where(['holder_user_id'=>$input['user_id']])->latest()->forPage($input['page'],10)->get();
             
        }

        echo $items->toJson();
    }
    
    public function getId($id){
        $item = \App\Item::find($id);
        $user = $item->user;
        $articles = \App\Article::select('id','title')->where(['item_id'=>$id])->latest()->limit(5)->get();
        $item->articles = $articles;
        $item->user_name = $user->name;
        echo $item->toJson();
    }

    public function getUser($id, $page=1){
        $items = \App\Item::Where(['owner_user_id'=>$id])->orWhere(['holder_user_id'=>$id])->forPage($page,10)->get();
        echo $items->toJson();
    }

    public function postPost(Request $request){
        $openid = $request->session()->get('openid');
        $user = \App\User::findOpenid($openid);
        $input = $request->input();
        $item = new \App\Item;
        $item->name = $input['name'];
        $item->des = $input['des'];
        if(empty($input['photo'])){
            $imgs = ['img/Blue_Book.png','img/Brown_Book.png','img/Green_Book.png','img/Red_Book.png'];
            $index = array_rand($imgs,1);
            $item->photo = $imgs[$index];
        }else{
            $item->photo = $input['photo'];
        }
        
        $item->transfer = boolval($input['transfer']) ? 1 : 0;
        $item->holder_user_id = $user->id;
        $item->owner_user_id = $user->id;
        $item->code = md5($user->id . uniqid());
        $item->save();
    }
    
    
}
