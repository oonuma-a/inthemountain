<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\item;


class ShopController extends Controller
{
    public function index(Request $request){
        // session()->flush();
        // dd($request->all());
        //ページネーション値配列
        $paginateArray = array(5,20,40,100);
        //表示
        //カテゴリ検索中の判定
        if(isset($request->category_search)){
            $itemdata = item::query();
            $category_search = $request->category_search;
            if(isset($category_search)){
                $itemdata->where('item_category','like','%'.$category_search.'%')->latest('update_at');
            }
        }else{
            $category_search = NULL;
        }
        //セール検索中の判定
        if(isset($request->sale_search)){
            $sale_search = 1;
            $itemdata = item::where('discount_price','<>',NULL)->latest('update_at');
        }else{
            $sale_search = NULL;
        }
        //ページネーション受信時の場合は値を変更
        if(isset($request->paginateChangeValue)){
            $paginateChangeValue = $request->paginateChangeValue;
        }else{
            $paginateChangeValue = 20;
        }
        //商品検索時は条件付きの商品表示へ変更
        if(isset($request->item_name_search)){
            $item_name_search = $request->item_name_search;
            if(!isset($itemdata)){
                $itemdata = item::query();
            }
            if(isset($item_name_search)){
                $itemdata->where('item_name','like','%'.$item_name_search.'%')->latest('update_at');
            }
        }else{
            $item_name_search = NULL;
        }
        if(!isset($itemdata)){
            $itemdata = item::latest('update_at');
            $item_name_search = NULL;
        }
        $itemdata = $itemdata->paginate($paginateChangeValue);
        //詳細表示機能を変更している場合
        if(isset($request->detail_select)){
            $detail_select = $request->detail_select;
            if($detail_select == 2){
                return view('shop.detail',  compact('itemdata','paginateArray','paginateChangeValue','item_name_search','category_search','sale_search','detail_select'));
            }
        }
        $detail_select = NULL;
        return view('shop.index', compact('itemdata','paginateArray','paginateChangeValue','item_name_search','category_search','sale_search','detail_select'));
    }

    public function shop_index_post(Request $request){
        //ページ表示用項目
        $paginateArray = array(5,20,40,100);
        $paginateChangeValue = 20;
        $item_name_search = NULL;
        $category_search = NULL;
        $sale_search = NULL;
        $detail_select = NULL;
        //表示機能
        $itemdata = item::latest('update_at')->paginate(20);
        return redirect()->route('shop.index', compact('itemdata','paginateArray','paginateChangeValue','item_name_search','category_search','sale_search','detail_select'));
    }
}