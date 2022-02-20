<?php

namespace App\Http\Controllers;
use App\Models\users;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function user_index_get(Request $request){
        //表示機能
        $userSelect = users::latest('update_at')->paginate(8);
        return view('user.index',compact('userSelect'));
        
    }
    public function user_index_post(Request $request){
        //削除処理user_delete_flg
        if(isset($request->user_delete_flg)){
            $deleteId = users::find($request->id)->delete();
        }
        //表示機能
        $userSelect = users::latest('update_at')->paginate(8);
        return view('user.index',compact('userSelect'));
    }
    public function user_create_get(){
        return view('user.create');
    }
    public function user_create_post(){
        return view('user.create');
    }
    public function user_edit_get(Request $request){
        //ユーザー情報更新画面
        if(isset($request->user_update_flg)){
            $userUpdate = users::find($request->id);
            return view('user.edit', compact('userUpdate'));
        }
        return view('user.edit');
    }
    public function user_edit_post(){
        return view('user.edit');
    }
}
