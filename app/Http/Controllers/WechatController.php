<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


class WechatController extends Controller
{

    private static function post($url,$data=''){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_POST,true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    public function getIndex(){
        echo json_encode(['appid'=>env('APPID','')]);
    }

    public function getOauth(Request $request){
        $appid = env('WX_APPID');
        $secret = env('WX_SECRET');
    	$code = $request->input('code','');

        if($_SERVER["SERVER_PORT"] == '80'){
            $redirect = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
        }else{
            $redirect = 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"] .$_SERVER["REQUEST_URI"];
        }
        
        

        if(empty($code)){
            header("location: https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$redirect}&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect");
            exit();
        }else{
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$secret}&code={$code}&grant_type=authorization_code";
            $res = $this->post($url);
            $json = json_decode($res,true);
            if(isset($json['openid'])){
                $request->session()->put('openid',$json['openid']);
            }
            header("location:../../");
            exit();
        }
    }

    public function getOauthredirect(){
        $appid = env('WX_APPID');
        $url='http://'.$_SERVER['SERVER_NAME']. '/pl'; 
        $redirect = $url . '/wechat/oauth'; //isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $url;
        header("location: https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$redirect}&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect");
        exit();
    }

    public function getUser(Request $request){
        $access_token = $request->input('access_token','');
        $openid = $request->input('openid','');
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";
        $res = $this->post($url);
        echo $res;
    }
    
    
}
