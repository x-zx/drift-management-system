<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


class AuthController extends Controller
{
    public function getIndex(Request $request){
    	$openid = $request->input('openid');
    //   echo $recommends->toJson();
    }

    public function getOpenid(Request $request){
    	$openid = $request->input('openid','');
        if(!empty($openid)){
            $request->session()->put('openid',$openid);
        }
    }
    
    
}
