<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\users;
use App\Models\item;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UsersRequest;

class UserController extends Controller
{
    public function user_index_get(Request $request){
        //表示機能
        $userSelect = users::paginate(10);
        return view('user.index',compact('userSelect'));
        
    }
    public function user_index_post(Request $request){
        //削除処理
        if(isset($request->user_delete_flg)){
            $deleteId = users::find($request->id)->delete();
        }
        //表示機能
        $userSelect = users::paginate(10);
        return view('user.index',compact('userSelect'));
    }
    public function user_create_get(){
        return view('user.create');
    }
    public function user_create_post(UsersRequest $request){
        //ページ表示用項目
        $paginateArray = array(10,20,40,100);
        $paginateChangeValue = 20;
        $searchItemName = NULL;
        $item_search_flg = NULL;

        //ユーザー登録処理
        if(isset($request->user_create_flg)){
            $userNewData = $request->all();
            unset($userNewData['_token']);
            $userInsert = new users;
            $userNewData['password'] = Hash::make($request->password);
            $userInsert->fill($userNewData)->save();
        }
        //表示機能
        $itemdata = item::latest('update_at')->paginate($paginateChangeValue);
        return redirect()->route('shop.index',compact('itemdata','paginateArray','paginateChangeValue','searchItemName','item_search_flg'));
    }
    public function user_edit_get(Request $request){
        //ユーザー情報更新画面
        if(isset($request->user_update_flg)){
            $userUpdate = users::find($request->id);
            return view('user.edit', compact('userUpdate'));
        }
        return view('shop.index');
    }
    public function user_edit_post(UsersRequest $request){
        //ページ表示用項目
        $paginateArray = array(10,20,40,100);
        $paginateChangeValue = 20;
        $searchItemName = NULL;
        $item_search_flg = NULL;

        //ユーザー情報更新処理
        if(isset($request->user_update_flg)){
            $userUpdateData = $request->all();
            unset($userUpdateData['_token']);
            $updateuser = users::find($request->id);
            $updateuser->fill($userUpdateData)->save();
        }
        //表示機能
        $itemdata = item::latest('update_at')->paginate($paginateChangeValue);
        return redirect()->route('shop.index',compact('itemdata','paginateArray','paginateChangeValue','searchItemName','item_search_flg'));
    }
}
