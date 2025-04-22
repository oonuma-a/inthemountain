<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\item;
use App\Services\ItemService;


class ShopController extends Controller
{

    protected $itemService;

    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    public function index(Request $request){

        $inputs = $request->only([
            'category_search',
            'sale_search',
            'paginateChangeValue',
            'item_name_search',
            'detail_select'
        ]);

        //ページネーション値配列
        $pagedata = [];
        $pagedata['paginateArray'] = array(5,20,40,100);
        $pagedata['paginateChangeValue'] = $inputs['paginateChangeValue'] ?? 20;

        // Itemテーブルから表示データを取得
        $itemdata = $this->itemService->get($inputs);

        // アイテムカテゴリ一覧を取得
        $categories = config('constants.ITEM_CATEGORIES');
        $data = compact('itemdata', 'categories', 'pagedata', 'inputs');

        // 画面の表示モードを設定
        if(isset($request->detail_select)){
            //表示モードが詳細表示の場合
            $detail_select = $request->detail_select;
            if($detail_select == 2){
                return view('shop.detail', $data);
            }else {
                //表示モードが一覧表示の場合
                return view('shop.index', $data);
            }
        }
        return view('shop.index', $data);
    }
}