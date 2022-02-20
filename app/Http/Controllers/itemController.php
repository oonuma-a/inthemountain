<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\item;

class itemController extends Controller
{
    public function item_index_get(Request $request){
        //商品情報表示画面
        if(isset($request->item_check_flg)){
            $selectItem = item::find($request->id);
            return view('item.index', compact('selectItem'));
        }
        return view('item.index');

    }
    public function item_index_post(Request $request){
        //商品情報表示画面
        if(isset($request->item_check_flg)){
            $selectItem = item::find($request->id);
            return view('item.index', compact('selectItem'));
        }
        return view('item.index');
    }
    public function item_create_get(){
        return view('item.create');
    }
    public function item_create_post(){
        return view('item.create');
    }
    public function item_edit_get(Request $request){
        //商品更新処理：更新する商品を表示
        $updateItem = item::find($request->id);
        return view('item.edit', compact('updateItem'));
    }
    public function item_edit_post(Request $request){
        //商品更新処理

    }
}
