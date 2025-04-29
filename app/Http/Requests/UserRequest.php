<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (!empty($this->old())) {
            return [];
        }
        // ユーザーID編集の場合
        if ($this -> user_id == Auth::user()->user_id) { 
            $unique_user_id = 'unique:users,user_id,' . $this -> user_id . ',user_id';
        // ユーザーID新規の場合
        } else { 
            $unique_user_id = 'unique:users';
        }
        // メールドレス編集の場合
        if ($this -> email == Auth::user()->email) { 
            $unique_email = 'unique:users,email,' . $this -> email . ',email';
        // メールドレス新規の場合
        } else { 
            $unique_email = 'unique:users';
        }
        return[
            'user_id' => 'required|max:10|regex:/^[!-~]+$/|'. $unique_user_id,
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
            'user_name' => 'max:10',
            'email' => 'required|email|max:50|'. $unique_email,
        ];

    }


    public function messages()
    {
        return [
            'user_id.required' => 'ユーザーIDを入力してください',
            'user_id.max' => 'ユーザーIDは10文字以内で入力してください',
            'user_id.regex' =>  'ユーザーIDは半角英数記号で登録してください',
            'user_id.unique' => 'ユーザーIDはすでに使用されています',
            'password.required' => 'パスワードを入力してください' ,
            'password.confirmed' => 'パスワードと確認用パスワードが異なります' ,
            'password_confirmation.required' => '確認用パスワードを入力してください' ,
            'password.min' => 'パスワードは最低6文字以上入力してください' ,
            'user_name.max' => 'ユーザー名は10文字以下で入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスではありません',
            'email.max' => 'メールアドレスは50文字以下で登録してください',
            'email.unique' => 'メールアドレスはすでに使用されています',
        ];

    }
}
