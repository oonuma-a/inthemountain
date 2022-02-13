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
        $paginateArray = array(8,20,60,100);
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
        
        $paginateArray = array(8,20,60,100);
        //商品投稿処理
        if(isset($request->item_insert_flg)){
            $item_new_data = $request->all();
            unset($item_new_data['_token']);
            $item_insert = new item;
            $item_insert->timestamps = false; 
            //商品画像投稿処理
            if(isset($request->image)){
                $filename=$request->file('image')->getClientOriginalName();
                $item_new_data['image']=$request->file('image')->store('public/image');
            }
            $item_insert->fill($item_new_data)->save();
            //表示機能
            $itemdata = item::paginate(8);
        //商品削除処理
        }else if(isset($request->item_delete_flg)){
            $deleteId = item::find($request->id);
            Storage::delete('public/image', $deleteId->image);
            $deleteId = item::find($request->id)->delete();
            //表示機能
            $itemdata = item::paginate(8);
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