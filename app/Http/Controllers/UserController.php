<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\users;
use App\Models\item;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request){
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
    public function create(){
        return view('user.create');
    }
    public function store(UserRequest $request){
        //ページ表示用項目
        $paginateArray = array(5,20,40,100);
        $paginateChangeValue = 20;
        $item_name_search = NULL;
        $category_search = NULL;
        $sale_search = NULL;
        $detail_select = NULL;
        //表示機能
        $itemdata = item::latest('update_at')->paginate($paginateChangeValue);

        //ユーザー登録処理
        if(isset($request->user_create_flg)){
            $userNewData = $request->all();
            unset($userNewData['_token']);
            $userNewData['password'] = Hash::make($request->password);
            $userInsert = new users;
            $userInsert->fill($userNewData)->save();
        }

        //ログイン処理(管理ユーザー以外)
        $credentials = $request->only(
            'user_id' ,
            'password'
        );
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->route('shop.index',  compact('itemdata','paginateArray','paginateChangeValue','item_name_search','category_search','sale_search','detail_select'));
        }



        return redirect()->route('shop.index',compact('itemdata','paginateArray','paginateChangeValue','item_name_search','category_search','sale_search','detail_select'));
    }
    public function edit(Request $request){
        //ユーザー情報更新画面
        if(isset($request->user_update_flg)){
            $userUpdate = users::find($request->id);
            return view('user.edit', compact('userUpdate'));
        }
        return view('shop.index');
    }
    public function update(UserRequest $request){
        //ページ表示用項目
        $paginateArray = array(5,20,40,100);
        $paginateChangeValue = 20;
        $item_name_search = NULL;
        $category_search = NULL;
        $sale_search = NULL;
        $detail_select = NULL;

        //ユーザー情報更新処理
        if(isset($request->user_update_flg)){
            $userUpdateData = $request->all();
            unset($userUpdateData['_token']);
            $userUpdateData['password'] = Hash::make($request->password);
            $updateuser = users::find($request->id);
            $updateuser->fill($userUpdateData)->save();
        }
        //表示機能
        $itemdata = item::latest('update_at')->paginate($paginateChangeValue);
        return redirect()->route('shop.index',compact('itemdata','paginateArray','paginateChangeValue','item_name_search','category_search','sale_search','detail_select'));
    }
}
