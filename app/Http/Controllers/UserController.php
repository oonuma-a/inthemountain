<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function user_index_get(Request $request){
        //商品情報表示画面
        if(isset($request->user_check_flg)){
            $user_select = user::find($request->id);
            return view('user.index', compact('user_select'));
        }
        return view('user.index');

    }
    public function user_index_post(Request $request){
        //商品情報表示画面
        if(isset($request->user_check_flg)){
            $user_select = user::find($request->id);
            return view('user.index', compact('user_select'));
        }
        return view('user.index');

    }
    public function user_create_get(){
        return view('user.create');
    }
    public function user_create_post(){
        return view('user.create');
    }
    public function user_edit_get(){
        return view('user.index');
    }
    public function user_edit_post(){
        return view('user.index');
    }
}
