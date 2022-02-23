<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\item;
use App\Models\shop;
use App\Models\users;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;


class ShopController extends Controller
{
    public function shop_index_get(Request $request){
        //ページネーション値配列
        $paginateArray = array(20,50,100);
        //ページネーション
        if(isset($request->item_pagination)){
            $itemdata = item::latest('update_at')->paginate($request->item_pagination);
            $paginateChangeValue = $request->item_pagination;
            return view('shop.index',compact('itemdata','paginateChangeValue','paginateArray'));
        }
        //詳細表示機能
        if(isset($request->detail_select)){
            if($request->detail_select == 2){
                $itemdata = item::latest('update_at')->paginate(20);
                return view('shop.index',compact('itemdata','paginateArray'));
            }
        }
        //表示機能
        $itemdata = item::latest('update_at')->paginate(20);
        return view('shop.index',compact('itemdata','paginateArray'));
    }
    public function shop_index_post(Request $request){
        $paginateArray = array(10,20,60,100);
        //商品投稿処理
        if(isset($request->item_insert_flg)){
            $itemInsertData = $request->all();
            unset($itemInsertData['_token']);
            $insertItem = new item;
            //商品画像 投稿処理
            if(isset($request->image)){
                $filename = $request->file('image')->getClientOriginalName();
                $itemInsertData['image']=$request->file('image')->store('public/image');
            }
            $insertItem->fill($itemInsertData)->save();
            //表示機能
            $itemdata = item::latest('update_at')->paginate(20);
        //商品更新処理
        }else if(isset($request->item_update_flg)){
            $itemUpdateData = $request->all();
            unset($itemUpdateData['_token']);
            $updateItem = item::find($request->id);
            //商品画像 更新処理
            if(isset($request->image)){
                Storage::delete('public/image', $updateItem->image);
                $filename = $request->file('image')->getClientOriginalName();
                $itemUpdateData['image']=$request->file('image')->store('public/image');
            }
            $updateItem->fill($itemUpdateData)->save();
            //表示機能
            $itemdata = item::latest('update_at')->paginate(20);
        //商品削除処理
        }else if(isset($request->item_delete_flg)){
            $deleteId = item::find($request->id);
            Storage::delete('public/image', $deleteId->image);
            $deleteId = item::find($request->id)->delete();
            //表示機能
            $itemdata = item::latest('update_at')->paginate(20);
        //新規ユーザー登録処理
        }else if(isset($request->user_create_flg)){
            //ユーザー登録処理
            $userNewData = $request->all();
            unset($userNewData['_token']);
            $userInsert = new users;
            $userNewData['password'] = Hash::make($request->password);
            $userInsert->fill($userNewData)->save();
            //表示機能
            $itemdata = item::latest('update_at')->paginate(20);
        //ユーザー情報更新処理
        }else if(isset($request->user_update_flg)){
            $userUpdateData = $request->all();
            unset($userUpdateData['_token']);
            $updateuser = users::find($request->id);
            $updateuser->fill($userUpdateData)->save();
            //表示機能
            $itemdata = item::latest('update_at')->paginate(20);
        }else{
            //表示機能
            $itemdata = item::latest('update_at')->paginate(20);
        }
        return view('shop.index',compact('itemdata','paginateArray'));
    }
    public function shop_detail_get(Request $request){
        //ページネーション値配列
        $paginateArray = array(10,20,60,100);
        //ページネーション
        if(isset($request->item_pagination)){
            $itemdata = item::latest('update_at')->paginate($request->item_pagination);
            $paginateChangeValue = $request->item_pagination;
            return view('shop.detail',compact('itemdata','paginateChangeValue','paginateArray'));
        }
        //表示機能
        $itemdata = item::latest('update_at')->paginate(20);
        return view('shop.detail',compact('itemdata','paginateArray'));
    }
    public function shop_create_get(){
        return view('shop.index');
    }
    public function shop_create_post(){
        return view('shop.index');
    }
    public function shop_edit_get(){
        return view('shop.index');
    }
    public function shop_edit_post(){
        return view('shop.index');
    }
}