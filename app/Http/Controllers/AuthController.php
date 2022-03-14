<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\item;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function auth_index_get(Request $request){
        //ページ表示用項目
        $paginateArray = array(5,20,40,100);
        $paginateChangeValue = 20;
        $item_name_search = NULL;
        $category_search = NULL;
        $sale_search = NULL;
        $detail_select = NULL;
        //表示機能
        $itemdata = item::latest('update_at')->paginate($paginateChangeValue);
        if(Auth::check()){
            return view('shop.index',  compact('itemdata','paginateArray','paginateChangeValue','searchItemName','item_search_flg'));
        }else{
            return view('auth.index');
        }
    }

    
    public function auth_index_post(Request $request){
        //ページ表示用項目
        $paginateArray = array(5,20,40,100);
        $paginateChangeValue = 20;
        $item_name_search = NULL;
        $category_search = NULL;
        $sale_search = NULL;
        $detail_select = NULL;

        //表示機能
        $itemdata = item::latest('update_at')->paginate($paginateChangeValue);
        
        //ログアウト処理
        if(isset($request->logout_flg)){
            Auth::logout();
            return redirect()->route('shop.index',  compact('itemdata','paginateArray','paginateChangeValue','item_name_search','category_search','sale_search','detail_select'));
        }
        //ログイン処理
        if(Auth::check()){
            return redirect()->route('shop.index',  compact('itemdata','paginateArray','paginateChangeValue','item_name_search','category_search','sale_search','detail_select'));
        }else{
            if(isset($request->login_flg)){
                $credentials = $request->only(
                    'user_id' ,
                    'password'
                );
                if(Auth::attempt($credentials)){
                    $request->session()->regenerate();
                    return redirect()->route('shop.index',  compact('itemdata','paginateArray','paginateChangeValue','item_name_search','category_search','sale_search','detail_select'));
                }
                return back()->withErrors([
                    'login_error'=>'ユーザーIDとパスワードが一致しません。',
                ]);
            }
            return view('auth.index');
        }
    }
}