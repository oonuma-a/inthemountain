<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\item;
use App\Models\shop;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;



class ShopController extends Controller
{
    public function shop_index_get(Request $request){
        //ページネーション値配列
        $paginateArray = array(10,20,60,100);
        //ページネーション
        if(isset($request->item_pagination)){
            $itemdata = item::paginate($request->item_pagination);
            $paginateChangeValue = $request->item_pagination;
            return view('shop.index',compact('itemdata','paginateChangeValue','paginateArray'));
        }
        //表示機能
        $itemdata = item::paginate(8);
        return view('shop.index',compact('itemdata','paginateArray'));
    }
    public function shop_index_post(Request $request){
        $paginateArray = array(10,20,60,100);
        //商品投稿処理
        if(isset($request->item_insert_flg)){
            $itemInsertData = $request->all();
            unset($itemInsertData['_token']);
            $insertItem = new item;
            $insertItem->timestamps = false; 
            //商品画像 投稿処理
            if(isset($request->image)){
                $filename = $request->file('image')->getClientOriginalName();
                $itemInsertData['image']=$request->file('image')->store('public/image');
            }
            $insertItem->fill($itemInsertData)->save();
            //表示機能
            $itemdata = item::paginate(8);
        //商品更新処理
        }else if(isset($request->item_update_flg)){
            $itemUpdateData = $request->all();
            unset($itemUpdateData['_token']);
            $updateItem = item::find($request->id);
            $updateItem->timestamps = false; 
            //商品画像 更新処理
            if(isset($request->image)){
                Storage::delete('public/image', $updateItem->image);
                $filename = $request->file('image')->getClientOriginalName();
                $itemUpdateData['image']=$request->file('image')->store('public/image');
            }
            $updateItem->fill($itemUpdateData)->save();
            //表示機能
            $itemdata = item::paginate(8);
            return view('shop.index',compact('itemdata','paginateArray'));
        //商品削除処理
        }else if(isset($request->item_delete_flg)){
            $deleteId = item::find($request->id);
            Storage::delete('public/image', $deleteId->image);
            $deleteId = item::find($request->id)->delete();
            //表示機能
            $itemdata = item::paginate(8);
        //新規ユーザー登録処理
        }else if(isset($request->user_create_flg)){
            //ユーザー登録処理
            $user_new_data = $request->all();
            unset($user_new_data['_token']);
            $user_insert = new user;
            $user_insert->fill($user_new_data)->save();
            //表示機能
            $itemdata = item::paginate(8);

            //表示機能
            $itemdata = item::paginate(8);
            return view('shop.index',compact('itemdata','paginateArray'));
        }else{
            //表示機能
            $itemdata = item::paginate(8);
        }
        return view('shop.index',compact('itemdata','paginateArray'));
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