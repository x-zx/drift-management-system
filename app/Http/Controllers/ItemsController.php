<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ItemsController extends Controller
{
    public function index(){
        $item = new \App\Item;
        $item->name = '测试书籍';
        $item->des = '测试介绍';
        $item->owner_user_id = 1;
        $item->holder_user_id = 1;
        $item->save();
    }

    public function create(Request $request){
        
    }

    public function update(){

    }

    public function store(Request $request){
        // $this->validate($request,[
        //     'name' => 'require|max:255',
        //     'des'=>'require',

        // ]);
        $input = $request->all();
        Item::create($input);
    }
    public function transferTo(){

    }


}
