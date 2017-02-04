<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


class UserController extends Controller
{
    public function getIndex(Request $request){
        $openid = $request->session()->has('openid') ? $request->session()->get('openid') : '';
        if(!empty($openid)){
            $user = \App\User::findOpenid($openid);
            if($user){
                $item_num = $user->hold_items()->count();
                $article_num = $user->articles()->count();
                $user->item_num = $item_num;
                $user->article_num = $article_num;
                $user->email_md5 = md5($user->email);
                echo $user->toJson();
            }else{
                $user = new \App\User;
                $user->openid = $openid;
                $user->save();
            }
        }
        
        
    }
    
    public function getId($id){
        $user = \App\User::find($id);
        if($user){
            $item_num = $user->hold_items()->count();
            $article_num = $user->articles()->count();
            $user->item_num = $item_num;
            $user->article_num = $article_num;
            $user->email_md5 = md5($user->email);
        }
        echo $user->toJson();
    }

    public function postUpdate(Request $request){
        $openid = $request->session()->has('openid') ? $request->session()->get('openid') : '';
        $input = $request->input();
        $user = \App\User::findOpenid($openid);
        if($user){
            $user->name = $input['name'];
            $user->sex = $input['sex'];
            $user->class = $input['class'];
            $user->email = $input['email'];
            $user->contact = $input['contact'];
            $user->save();
        }
        
        //$info = json_encode($input,true);
        //var_dump($info);
        //$user = \App\User::findOpenid($input['openid']);

    }
    
}
