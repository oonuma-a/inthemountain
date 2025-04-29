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

    public function cart_index(Request $request){
        // アイテムカテゴリ一覧を取得
        $categories = config('constants.ITEM_CATEGORIES');

        $itemQuantity = [];
        $itemdata = [];
        //カート表示機能
        $cartData = $request->session()->get('cart_data');

        if(!isset($cartData)){
            $datas = compact('categories', 'itemdata','itemQuantity');
            return view('item.cart', $datas);
        }

        $cartItemIds = array_column($cartData, 'cart_id');
        $itemdata = $this->itemService->findItemsByIds($cartItemIds);

        //商品個数集計処理
        if(isset($itemdata)){
            foreach($itemdata as $data){
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

        $datas = compact('categories', 'itemdata','itemQuantity');

        return view('item.cart', $datas);
    }

    /**
     * カート内アイテム個数編集機能
     */
    public function cart_update(Request $request){
        $cart_id = $request->id;
        $cart_item_number = $request->item_number;

        // 既存のカートデータ取得
        $cartData = $request->session()->get('cart_data', []);

        $cartData[$cart_id] = [
            'cart_id' => $cart_id,
            'cart_item_number' => $cart_item_number,
        ];

        // カートに上書き
        $request->session()->put('cart_data', $cartData);

        return redirect()->route('cart.index');
    }

    /**
     * カート内アイテム削除機能
     */
    public function cart_remove(Request $request)
    {
        $delete_id = $request->id;

        $cartData = $request->session()->get('cart_data', []);

        if (isset($cartData[$delete_id])) {
            unset($cartData[$delete_id]);
        }

        // セッションに更新された配列を再設定
        $request->session()->put('cart_data', $cartData);

        return redirect()->route('cart.index');
    }

    /**
     * カート内クリア機能
     */
    public function cart_clear(Request $request){
        $request->session()->forget('cart_data');
        return redirect()->route('cart.index');
    }
}
