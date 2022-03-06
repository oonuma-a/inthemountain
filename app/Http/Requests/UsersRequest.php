<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
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
        if ($this -> user_id) { 
            $unique_user_id = 'unique:users,user_id,' . $this -> user_id . ',user_id';
        // ユーザーID新規の場合
        } else { 
            $unique_user_id = 'unique:users,user_id';
        }
        
        // メールドレス編集の場合
        if ($this -> email) { 
            $unique_email = 'unique:users,email,' . $this -> email . ',email';
        // メールドレス新規の場合
        } else { 
            $unique_email = 'unique:users,email';
        }
    
        return[
            'user_id' => 'required|max:15|regex:/^[!-~]+$/|'. $unique_user_id,
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
            'user_name' => 'max:15',
            'email' => 'required|email|max:255|'. $unique_email,
    
        ];
        
    }
    

    public function messages()
    {
        return [
            'user_id.required' => 'ユーザーIDを入力してください',
            'user_id.max' => 'ユーザーIDは15文字以内で入力してください',
            'user_id.unique' => 'ユーザーIDはすでに使用されています',
            'user_id.regex' =>  'ユーザーIDは半角英数記号で登録してください',
            'password.required' => 'パスワードを入力してください' ,
            'password.confirmed' => 'パスワードと確認用パスワードが異なります' ,
            'password_confirmation.required' => '確認用パスワードを入力してください' ,
            'password.min' => 'パスワードは最低6文字以上入力してください' ,
            'user_name.max' => 'ユーザー名は15文字以下で入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスではありません',
            'email.max' => 'メールアドレスは255文字以下で登録してください',
            'email.unique' => 'メールアドレスはすでに使用されています',
        ];
        
    }
}
