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
    public function shop_index_post(){
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