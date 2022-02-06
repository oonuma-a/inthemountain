<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\item;
use App\Models\shop;


class ShopController extends Controller
{
    public function shop_index_get(Request $request){
        //表示機能
        $itemdata = item::all();
        return view('shop.index',compact('itemdata'));
    }
    public function shop_index_post(Request $request){
        //商品投稿処理
        if(isset($request->item_insert_flg)){
            $item_new_data = $request->all();
            unset($item_new_data['_token']);
            $item_insert = new item;
            $item_insert->timestamps = false; 
            $item_insert->fill($item_new_data)->save();
            //表示機能
            $itemdata = item::all();
            return view('shop.index',compact('itemdata'));
        }
        return view('shop.index');
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