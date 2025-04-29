<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index(Request $request){
        // アイテムカテゴリ一覧を取得
        $categories = config('constants.ITEM_CATEGORIES');
        $datas = compact('categories');

        if(Auth::check()){
            return view('shop.index', $datas);
        }

        return view('auth.index', $datas);
    }

    /**
     * ログイン処理
     */
    public function login(Request $request){
        if(Auth::check()){
            return redirect()->route('shop.index');
        }else{
            $credentials = $request->only(
                'user_id' ,
                'password'
            );
            if(Auth::attempt($credentials)){
                $request->session()->regenerate();
                return redirect()->route('shop.index');
            }
            return back()->withErrors([
                'login_error'=>'ユーザーIDとパスワードが一致しません。',
            ]);
        }

        return redirect()->route('auth.index');
    }

    /**
     * ログアウト処理
     */
    public function logout(Request $request){
    if(Auth::check()) {
        Auth::logout();
    }
        return redirect()->route('shop.index');
    }
}