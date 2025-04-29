<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Services\ItemService;
use App\Http\Requests\ItemRequest;

class itemController extends Controller
{
    protected $itemService;

    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    /**
     * 商品一覧画面
     */
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

        //商品情報表示画面
        $itemdata = $this->itemService->get($inputs);

        // アイテムカテゴリ一覧を取得
        $categories = config('constants.ITEM_CATEGORIES');

        $datas = compact('itemdata', 'categories', 'pagedata', 'inputs');

        return view('item.index', $datas);
    }

    public function show($id, Request $request){
        //商品情報表示画面
        $itemdata = $this->itemService->findItemByID($id);

        // アイテムカテゴリ一覧を取得
        $categories = config('constants.ITEM_CATEGORIES');

        $datas = compact('itemdata', 'categories');

        return view('item.view', $datas);
    }

    public function create(){
        // アイテムカテゴリ一覧を取得
        $categories = config('constants.ITEM_CATEGORIES');

        $datas = compact('categories');

        return view('item.create', $datas);
    }

    /**
     * 商品登録処理
     */
    public function store(ItemRequest $request){

        $itemData = $request->all();

        try {
            $insertItem = $this->itemService->createItem($itemData);

            return redirect()->route('item.view', ['id' => $insertItem->id]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', '登録に失敗しました。')->withInput();
        }
    }

    public function edit($id, Request $request){
        // アイテムカテゴリ一覧を取得
        $categories = config('constants.ITEM_CATEGORIES');

        //商品更新処理：更新する商品を表示
        $itemdata = $this->itemService->findItemByID($id);

        $datas = compact('categories', 'itemdata');

        return view('item.edit', $datas);
    }

    /**
     * 商品更新処理
     */
    public function update($id, ItemRequest $request){
        $updateItemData = $request->all();

        $returnPageArr = [
            'id' => $id
        ];

        if (!empty(request()->query('from'))) {
            $returnPageArr['from'] = request()->query('from');
        }

        try {
            $this->itemService->updateItem($id, $updateItemData);

            return redirect()->route('item.view', $returnPageArr);
        } catch (Exception $e) {
            return redirect()->back()->with('error', '登録に失敗しました。')->withInput();
        }
    }

    public function item_cart_get(Request $request){
        //カート表示機能
        $cartData = $request->session()->get('cart_data');
        if(isset($cartData)){
            $cart_id = array_column($cartData, 'cart_id');
            $itemData = item::find($cart_id);
        }else{
            $itemData = NULL;
        }

        //商品個数集計処理
        if(isset($itemData)){
            $itemQuantity = [];
            foreach($itemData as $data){
                $Quantity = 0;
                foreach($cartData as $cart){
                    if($data->id == $cart['cart_id']){
                        $Quantity = $Quantity + (int)$cart['cart_item_number'];
                    }
                }
                $itemQuantity = array_merge($itemQuantity,['id_'.$data->id => $Quantity]);
            }
        }else{
            $itemQuantity = NULL;
        }
        return view('item.cart', compact('itemData','itemQuantity'));
    }

    public function destroy($id, Request $request) {
        // 削除後の画面を設定
        $from = $request->input('from');

        if (!empty($from)) {
            switch ($from) {
                case 'shop':
                    $redirectRoute = route('shop.index');
                    break;
                case 'item':
                    $redirectRoute = route('item.index');
                    break;
                case 'cart':
                    $redirectRoute = route('cart.index');
                    break;
                default:
                    $redirectRoute = route('shop.index');
                    break;
            }
        } else {
            $redirectRoute = route('shop.index');
        }

        try {
            $this->itemService->deleteItemByID($id);

            return redirect($redirectRoute);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    public function item_cart_post(Request $request){
        //カート追加機能
        if(isset($request->cart_add_flg)){
            $cart_id = $request->id;
            $cart_item_number = $request->item_number;
            $cartData = compact('cart_id','cart_item_number');
            $request->session()->push('cart_data', $cartData);
        }
        //カート削除機能
        // session()->flush();
        // dd($request->all());
        if(isset($request->cart_delete_flg)){
            //データを取得しセッションクリア
            $cartData = $request->session()->get('cart_data');
            $request->session()->flush();
            //削除データID取得
            $delete_id = $request->id;
            foreach($cartData as $data){
                if($data['cart_id'] == $delete_id){
                    continue;
                }else{
                    $cart_id = $data['cart_id'];
                    $cart_item_number = $data['cart_item_number'];
                    $cartData = compact('cart_id','cart_item_number');
                    $request->session()->push('cart_data', $cartData);
                }
            }
            // dd();
            // dd(session()->all());
        }

        //カートを空にする
        if(isset($request->cart_drop_flg)){
            $request->session()->flush();
        }
        //カート表示機能
        $cartData = $request->session()->get('cart_data');
        if(isset($cartData)){
            $cart_id = array_column($cartData, 'cart_id');
            $itemData = item::find($cart_id);
        }else{
            $itemData = NULL;
        }

        //商品個数集計処理
        if(isset($itemData)){
            $itemQuantity = [];
            foreach($itemData as $data){
                $Quantity = 0;
                foreach($cartData as $cart){
                    if($data->id == $cart['cart_id']){
                        $Quantity = $Quantity + (int)$cart['cart_item_number'];
                    }
                }
                $itemQuantity = array_merge($itemQuantity,['id_'.$data->id => $Quantity]);
            }
        }else{
            $itemQuantity = NULL;
        }
        return redirect()->route('item.cart', compact('itemData','itemQuantity'));
    }
}
