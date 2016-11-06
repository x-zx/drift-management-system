<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


class TransferController extends Controller
{

    public function getIndex(){
        echo "Transfer";
        echo session('openid');
    }
    
    public function getUser($id){
        $transfers = \App\Transfer::Where(['from_user_id'=>$id])->orWhere(['to_user_id'=>$id])->latest()->limit(5)->get();
        echo $transfers->toJson();
    }

    public function getItem($id){
    	$transfers = \App\Transfer::Where(['item_id'=>$id])->latest()->limit(5)->get();
    	foreach ($transfers as $transfer) {
    		$to_user = \App\User::find($transfer['to_user_id']);
    		$from_user = \App\User::find($transfer['from_user_id']);
    		if($to_user == $from_user) continue;
    		$transfers_log[] = [
    			'time'=>$transfer->updated_at->toDateString(),
    			'to'=>[
    				'id'=>$to_user->id,
    				'name'=>$to_user->name
    			],
    			'from'=>[
    				'id'=>$from_user->id,
    				'name'=>$from_user->name
    			]
    		];
    	}
    	echo json_encode($transfers_log);
    }

    public function getRequest(Request $request){
        $openid = $request->session()->has('openid') ? $request->session()->get('openid') : '';
        $user = \App\User::findOpenid($openid);

        if($user){
            //TODO GROUP BY
            $transfers = \App\Transfer::whereRaw('to_user_id <> from_user_id')->where('from_user_id','=',$user->id)->where('accept','=','0')->limit(15)->latest()->get();
            //dd($transfers);
            $trans_list = [];
            foreach ($transfers as $transfer) {
                $trans_user = \App\User::find($transfer->to_user_id);

                $trans_item = \App\Item::find($transfer->item_id);
                
                //var_dump($transfer);
                $trans_list[] = ['id'=>$transfer->id, 'time'=>$transfer->created_at->toDateString(), 'user_id'=>$trans_user->id, 'user_name'=>$trans_user->name, 'user_class'=>$trans_user->class, 'user_contact'=>$trans_user->contact, 'user_email'=>$trans_user->email, 'item_name'=>$trans_item->name];
            }
            echo json_encode($trans_list);
        }
    }

    public function getNew(Request $request){
        $openid = $request->session()->has('openid') ? $request->session()->get('openid') : '';
        $user = \App\User::findOpenid($openid);
        $input = $request->input();
        $item = \App\Item::find($input['item_id']);
        if($item && $user){
            if($item->holder_user_id != $user->id){
                $transfer = new \App\Transfer;
                $transfer->item_id = $item->id;
                $transfer->to_user_id = $user->id;
                $transfer->from_user_id = $item->holder_user_id;
                $transfer->save();
                echo json_encode(['msg'=>'申请已发送']);
            }else{
                echo json_encode(['msg'=>'已经拥有本书']);
            }
            
        }
    }

    // public function postRequest(Request $request){
    //     $openid = $request->session()->has('openid') ? $request->session()->get('openid') : '';
    //     $user = \App\User::findOpenid($openid);
    //     $input = $request->input();

    //     if($user){
    //         $transfer = \App\Transfer::find($input['trans_id']);
    //         $transfer->
    //     }
    // }



    public function getCode(Request $request){
        $openid = $request->session()->has('openid') ? $request->session()->get('openid') : '';
        $user = \App\User::findOpenid($openid);
        $input = $request->input();
        $code = $input['code'];
        $item = \App\Item::where('code','=',$code)->first();
        if($user && $item){ 
            if($item->owner_user_id != $item->holder_user_id && $item->owner_user_id == $user->id){
                 $transfer = new \App\Transfer;
                 $transfer->item_id = $item->id;
                 $transfer->from_user_id = $item->holder_user_id;
                 $transfer->to_user_id = $user->id;
                 $transfer->save();
            }else{
                $transfer = \App\Transfer::where('from_user_id','=',$item->holder_user_id)->where('to_user_id','=',$user->id)->whereRaw('to_user_id <> from_user_id')->first();
            }
            
            
            if($transfer){
                $owner_user = \App\User::find($item->owner_user_id);
                $holder_user = \App\User::find($item->holder_user_id);

                if($user->id == $item->owner_user_id){
                    $holder_user->star = $holder_user->star + 1;
                }

                $owner_user->star = $owner_user->star + 1;

                $item->holder_user_id = $user->id;
                $item->save();
                $owner_user->save();

                $msg = '已获得：' . $item->name;
            }else{
                $msg = '还没有申请漂流';
            }

        }else{
            $msg = '无法识别';
        }

        echo json_encode(['msg'=>$msg]);
    }
    
}
