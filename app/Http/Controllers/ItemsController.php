<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ItemsController extends Controller
{
    public function index(){
        
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
