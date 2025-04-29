<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Exception;
use App\Services\UserService;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request){
        // アイテムカテゴリ一覧を取得
        $categories = config('constants.ITEM_CATEGORIES');

        $userDatas = $this->userService->get();

        $datas = compact('categories', 'userDatas');

        return view('user.index', $datas);

    }

    public function create(){
        // アイテムカテゴリ一覧を取得
        $categories = config('constants.ITEM_CATEGORIES');

        $datas = compact('categories');
        return view('user.create', $datas);
    }

    /**
     * ユーザー登録処理
     */
    public function store(UserCreateRequest $request){
        $insertUserData = $request->all();

        $result = $this->userService->createUser($insertUserData);

        // ユーザー作成後の自動ログイン処理(管理ユーザー以外)
        $credentials = $request->only(
            'user_id' ,
            'password'
        );

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
        }

        return redirect()->route('shop.index');
    }

    /**
     * ユーザー情報更新画面
     */
    public function edit($id, Request $request){
        if(!Auth::check()){
            return redirect()->route('shop.index');
        }

        // ユーザーカテゴリ一覧を取得
        $categories = config('constants.ITEM_CATEGORIES');

        //ユーザー更新処理
        $userdata = $this->userService->findUserByID($id);

        $datas = compact('categories', 'userdata');

        return view('user.edit', $datas);
    }

    /**
     * ユーザー情報更新処理
     */
    public function update(UserUpdateRequest $request){

        $updateUserData = $request->all();

        try {
            $id = $updateUserData['id'];
            $this->userService->updateUser($id, $updateUserData);

            return redirect()->route('shop.index');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'ユーザー更新に失敗しました。')->withInput();
        }
    }

    /**
     * ユーザー削除処理
     */
    public function destroy($id, Request $request){
        try {
            $this->userService->deleteUserByID($id);

            return redirect()->route('user.index');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
