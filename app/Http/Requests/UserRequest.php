<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        
        return[
            'user_id' => 'required|max:15|unique:user|regex:/^[!-~]+$/',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
            'user_name' => 'max:15',
            'email' => 'required|email|max:255',
        ];
    }
    

    public function messages()
    {
        return [
            'user_id.required' => 'ユーザーIDをを入力してください',
            'user_id.max' => 'ユーザーIDは15文字以内で入力してください',
            'user_id.unique' => 'ユーザーIDはすでに使用されています',
            'user_id.regex' =>  'ユーザーIDは半角英数記号で登録してください',
            'password.required' => 'パスワードを入力してください' ,
            'password_confirmation.required' => 'パスワードを入力してください' ,
            'password.confirmed' => 'パスワードが異なります' ,
            'password.min' => 'パスワードは最低6文字以上入力してください' ,
            'user_name.max' => 'ユーザー名は15文字以下で入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスではありません',
            'email.max' => 'メールアドレスは255文字以下で登録してください',
        ];
        
    }
}
