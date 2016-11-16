<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Carbon\Carbon;

class TransferController extends Controller
{

    public function getIndex(){
        echo "Transfer";
        echo session('openid');
    }
    
    public function getUser($id){
        $transfers = \App\Transfer::Where(['from_user_id'=>$id])->orWhere(['to_user_id'=>$id])->whereRaw('to_user_id <> from_user_id')->latest()->limit(5)->get();
        echo $transfers->toJson();
    }

    public function getItem($id){
    	$transfers = \App\Transfer::where(['item_id'=>$id])->whereRaw('to_user_id <> from_user_id and accept = 1')->latest()->limit(5)->get();
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
            $transfers = \App\Transfer::whereRaw('to_user_id <> from_user_id and ' . "(from_user_id = {$user->id} or to_user_id = {$user->id})")->limit(20)->latest()->get();
            //dd($transfers);
            $trans_list = [];
            foreach ($transfers as $transfer) {
                $to_user = \App\User::find($transfer->to_user_id);
                $from_user = \App\User::find($transfer->from_user_id);
                $item = \App\Item::find($transfer->item_id);
                Carbon::setLocale('zh');
                $item->htime = Carbon::parse($item->expired_at)->diffForHumans();
                unset($item['des']);
                $trans_list[] = [
                    'id'=>$transfer->id,
                    'time'=>$transfer->created_at->toDateString(),
                    'to_user'=>$to_user,
                    'from_user'=>$from_user,
                    'item'=> $item,
                    'trans_way'=>$transfer->trans_way,
                    'accept'=>boolval($transfer->accept)
                ];
                //var_dump($transfer);

                // $trans_list[] = ['id'=>$transfer->id, 'time'=>$transfer->created_at->toDateString(), 'to_user'=>$to_user, 'from_user'=>$from_user, 'to_user_name'=>$trans_user->name, 'user_class'=>$trans_user->class, 'user_contact'=>$trans_user->contact, 'user_email'=>$trans_user->email, 'item_name'=>$trans_item->name];
            }
            echo json_encode($trans_list);
        }
    }

    public function getTransway(Request $request){
        $input = $request->input();
        $transfer = \App\Transfer::where('id','=',$input['id'])->first();
        if($transfer){
            $transfer->trans_way = $input['text'];
            $transfer->save();
            $msg = "交付方式修改成功";
        };
        
        echo json_encode(['msg'=>$msg]);

    }

    public function getNew(Request $request){
        $openid = $request->session()->has('openid') ? $request->session()->get('openid') : '';
        $user = \App\User::findOpenid($openid);
        $input = $request->input();
        $item = \App\Item::find($input['item_id']);
        if($item && $user){
            if($item->holder_user_id != $user->id){
                if(strtotime($item->expired_at)>strtotime(date("y-m-d h:i:s"))){
                    $transfer = \App\Transfer::where(['to_user_id'=>$user->id,'from_user_id'=>$item->holder_user_id])->latest()->first();
                    if(!$transfer){
                        $transfer = new \App\Transfer;
                    }
                    $transfer->item_id = $item->id;
                    $transfer->to_user_id = $user->id;
                    $transfer->from_user_id = $item->holder_user_id;
                    $transfer->save();
                    echo json_encode(['msg'=>'申请已发送']);
                }else{
                    Carbon::setLocale('zh');
                    $item->htime = Carbon::parse($item->expired_at)->diffForHumans();
                    echo json_encode(['msg'=>'不在有效期：'.$item->htime.'过期']);
                }
                
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
        $input = $request->input();
        $openid = $request->session()->has('openid') ? $request->session()->get('openid') : '';
        $user = \App\User::findOpenid($openid);
        $doTransfer = isset($input['transfer']) ? boolval($input['transfer']) : false;
        $code = $input['code'];
        $item = \App\Item::where('code','=',$code)->first();

        Carbon::setLocale('zh');
        $item->htime = Carbon::parse($item->expired_at)->diffForHumans();

        $owner_user = \App\User::find($item->owner_user_id);
        $holder_user = \App\User::find($item->holder_user_id);



        if($doTransfer && $user && $item){
            if($user->id == $item->owner_user_id){
                //当前用户是拥有者
                if($item->holder_user_id == $item->owner_user_id){
                    //当前项目拥有者持有
                    $msg = "已经拥有本书";
                    goto out;
                }else{
                    //还书成功上一个持有人 star + 1
                    $holder_user->star = $holder_user->star + 1;
                    $holder_user->save();
                    //还书给拥有者
                    $transfer = new \App\Transfer;
                    $transfer->item_id = $item->id;
                    $transfer->from_user_id = $item->holder_user_id;
                    $transfer->to_user_id = $user->id;
                    $transfer->accept = 1;
                    $transfer->trans_way = "确认归还";
                    $transfer->save();

                    $item->holder_user_id = $user->id;
                    $item->save();

                    //Carbon::setLocale('zh');
                    //$item->htime = Carbon::parse($item->expired_at)->diffForHumans();//->diffForHumans();

                    $msg = '确认归还：' . $item->name;
                   
                    goto out;
                }
            }else{
                //当前用户不是拥有者
                if(boolval($item->transfer)){
                    //允许多次漂流
                    $transfer = \App\Transfer::where('from_user_id','=',$item->holder_user_id)->where('to_user_id','=',$user->id)->first();
                }else{
                    if($item->holder_user_id == $item->owner_user_id){
                        $transfer = \App\Transfer::where('from_user_id','=',$item->holder_user_id)->where('to_user_id','=',$user->id)->first();
                    }
                }

                //查找漂流申请
                if($transfer){
                    //申请存在
                    //拥有者 star + 1
                    $owner_user->star = $owner_user->star + 1;
                    $owner_user->save();
                    //漂流记录更新
                    $transfer->accept = 1;
                    $transfer->save();
                    //持有人变更
                    $item->holder_user_id = $user->id;
                    $item->save();
                    $msg = '已获得：' . $item->name;
                    goto out;

                }else{
                    $msg = "还没有申请漂流";
                    goto out;
                }
            }

            }else{
                $msg = "无法识别";
                goto out;
        }
        

        // if($transfer && $user && $item){ 
        //     if($item->owner_user_id != $item->holder_user_id && $item->owner_user_id == $user->id){
        //          $transfer = new \App\Transfer;
        //          $transfer->item_id = $item->id;
        //          $transfer->from_user_id = $item->holder_user_id;
        //          $transfer->to_user_id = $user->id;
        //          $transfer->save();
        //     }else{
        //         $transfer = \App\Transfer::where('from_user_id','=',$item->holder_user_id)->where('to_user_id','=',$user->id)->whereRaw('to_user_id <> from_user_id')->first();
        //     }
            
            
        //     if($transfer){
        //         $owner_user = \App\User::find($item->owner_user_id);
        //         $holder_user = \App\User::find($item->holder_user_id);

        //         if($user->id == $item->owner_user_id){
        //             $holder_user->star = $holder_user->star + 1;
        //         }

        //         $owner_user->star = $owner_user->star + 1;

        //         $item->holder_user_id = $user->id;
        //         $item->save();
        //         $owner_user->save();

        //         $msg = '已获得：' . $item->name;
        //     }else{
        //         $msg = '还没有申请漂流';
        //     }

        // }else{
        //     $msg = '无法识别';
        // }
        out:
        echo @json_encode(['msg'=>$msg,'item_id'=>$item->id, 'item_name'=>$item->name, 'item_des'=>$item->des]);
    }
    
}
