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
        $paginateArray = array(10,20,40,100);
        //ページネーション受信時の場合は値を変更
        if(isset($request->paginateChangeValue)){
            $paginateChangeValue = $request->paginateChangeValue;
        }else{
            $paginateChangeValue = 20;
        }
        //商品検索時は条件付きの商品表示へ変更
        if(isset($request->item_search_flg)){
            $item_search_flg = 1;
            $itemdata = item::query();
            $searchItemName = $request->searchItemName;
            if(isset($searchItemName)){
                $itemdata->where('item_name','like','%'.$searchItemName.'%')->latest('update_at');
            }
        }else{
            $itemdata = item::latest('update_at');
            $searchItemName = NULL;
            $item_search_flg = NULL;
        }
        $itemdata = $itemdata->paginate($paginateChangeValue);
        //詳細表示機能を変更した場合
        if(isset($request->detail_select)){
            if($request->detail_select == 1){
                return view('shop.index',  compact('itemdata','paginateArray','paginateChangeValue','searchItemName','item_search_flg'));
            }else{
                return view('shop.detail', compact('itemdata','paginateArray','paginateChangeValue','searchItemName','item_search_flg'));
            }
        }
        return view('shop.index' , compact('itemdata','paginateArray','paginateChangeValue','searchItemName','item_search_flg'));
    }

    public function shop_index_post(Request $request){
        $paginateArray = array(10,20,40,100);
        $paginateChangeValue = 20;
        //表示機能
        $itemdata = item::latest('update_at')->paginate($paginateChangeValue);
        return redirect()->route('shop.index',compact('itemdata','paginateArray','paginateChangeValue'));
    }

    public function shop_detail_get(Request $request){
        //ページネーション値配列
        $paginateArray = array(10,20,40,100);
        //ページネーション受信時の場合は値を変更
        if(isset($request->paginateChangeValue)){
            $paginateChangeValue = $request->paginateChangeValue;
        }else{
            $paginateChangeValue = 20;
        }
        //商品検索時は条件付きの商品表示へ変更
        if(isset($request->item_search_flg)){
            $item_search_flg = 1;
            $itemdata = item::query();
            $searchItemName = $request->searchItemName;
            if(isset($searchItemName)){
                $itemdata->where('item_name','like','%'.$searchItemName.'%')->latest('update_at');
            }
        }else{
            $itemdata = item::latest('update_at');
            $searchItemName = NULL;
            $item_search_flg = NULL;
        }
        $itemdata = $itemdata->paginate($paginateChangeValue);
        //詳細表示機能を変更した場合
        if(isset($request->detail_select)){
            if($request->detail_select == 1){
                return view('shop.index',  compact('itemdata','paginateArray','paginateChangeValue','searchItemName','item_search_flg'));
            }else{
                return view('shop.detail', compact('itemdata','paginateArray','paginateChangeValue','searchItemName','item_search_flg'));
            }
        }
        return view('shop.detail' , compact('itemdata','paginateArray','paginateChangeValue','searchItemName','item_search_flg'));
    }
    public function shop_cart_get(Request $request){     
        //カート機能
        if(isset($request->cart_add)){
            Cart::add('293ad', 'Product 1', 1, 9.99, ['size' => 'large']);
        }
        return view('shop.detail' , compact('itemdata','paginateArray','paginateChangeValue','searchItemName','item_search_flg'));
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