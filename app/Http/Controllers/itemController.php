<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\item;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ItemRequest;

class itemController extends Controller
{
    public function item_index_get(Request $request){
        //商品情報表示画面
        $selectItem = item::all();
        return view('item.index', compact('selectItem'));
    }
    public function item_index_post(Request $request){
        //ページ表示用項目
        $paginateArray = array(10,20,40,100);
        $paginateChangeValue = 20;
        $searchItemName = NULL;
        $item_search_flg = NULL;
        
        //商品削除処理
        if(isset($request->item_delete_flg)){
            $deleteId = item::find($request->id);
            if(isset($deleteId->image)){
                Storage::delete('public/image', $deleteId->image);
            }
            $deleteId = item::find($request->id)->delete();
        }        

        //表示機能
        $itemdata = item::latest('update_at')->paginate($paginateChangeValue);
        //詳細表示機能を変更した場合
        if($request->item_index_delete){
            //商品情報表示画面
            $selectItem = item::find($request->id);
            return redirect()->route('item.index', compact('selectItem'));
        }
        if(isset($request->detail_select)){
            if($request->detail_select == 2){
                return redirect()->route('shop.detail',  compact('itemdata','paginateArray','paginateChangeValue','searchItemName','item_search_flg'));
            }
        }else{
                return redirect()->route('shop.index', compact('itemdata','paginateArray','paginateChangeValue','searchItemName','item_search_flg'));
        }
    }
    public function item_view_get(Request $request){
        //商品情報表示画面
        $selectItem = item::find($request->id);
        return view('item.view', compact('selectItem'));
    }
    public function item_view_post(Request $request){
        //商品情報表示画面
        $selectItem = item::find($request->id);
        return view('item.view', compact('selectItem'));
    }
    public function item_create_get(){
        return view('item.create');
    }
    public function item_create_post(ItemRequest $request){
        //ページ表示用項目
        $paginateArray = array(10,20,40,100);
        $paginateChangeValue = 20;
        $searchItemName = NULL;
        $item_search_flg = NULL;
        
        //商品投稿処理
        if(isset($request->item_insert_flg)){
            $itemInsertData = $request->all();
            unset($itemInsertData['_token']);
            $insertItem = new item;
            //商品画像 投稿処理
            if(isset($request->image)){
                $filename = $request->file('image')->getClientOriginalName();
                $itemInsertData['image']=$request->file('image')->store('public/image');
            }
            $insertItem->fill($itemInsertData)->save();
        }
        //表示機能
        $itemdata = item::latest('update_at')->paginate($paginateChangeValue);
        return redirect()->route('shop.index',compact('itemdata','paginateArray','paginateChangeValue','searchItemName','item_search_flg'));
    }
    public function item_edit_get(Request $request){
        //商品更新処理：更新する商品を表示
        $updateItem = item::find($request->id);
        if(isset($request->item_index_edit)){
            $item_index_edit = 1;
        }else{
            $item_index_edit = NULL;
        }
        return view('item.edit', compact('updateItem','item_index_edit'));
    }
    public function item_edit_post(ItemRequest $request){
        //ページ表示用項目
        $paginateArray = array(10,20,40,100);
        $paginateChangeValue = 20;
        $searchItemName = NULL;
        $item_search_flg = NULL;
        //商品更新処理
        $itemUpdateData = $request->all();
        unset($itemUpdateData['_token']);
        $updateItem = item::find($request->id);
        //商品画像 更新処理
        if(isset($request->image)){
            Storage::delete('public/image', $updateItem->image);
            $filename = $request->file('image')->getClientOriginalName();
            $itemUpdateData['image']=$request->file('image')->store('public/image');
        }
        $updateItem->fill($itemUpdateData)->save();
        //表示機能
        $itemdata = item::latest('update_at')->paginate($paginateChangeValue);
        if(isset($request->item_index_edit)){
            $selectItem = item::paginate(5);
            return redirect()->route('item.index', compact('selectItem'));
        }
        return redirect()->route('shop.index', compact('itemdata','paginateArray','paginateChangeValue','searchItemName','item_search_flg'));
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

    public function item_cart_post(Request $request){
        //カート追加機能
        $cart_id = $request->id;
        $cart_item_number = $request->item_number;
        $cartData = compact('cart_id','cart_item_number');
        $request->session()->push('cart_data', $cartData);
        
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
