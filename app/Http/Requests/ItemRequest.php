<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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
            'item_name' => 'required|max:30',
            'item_category' => 'required',
            'item_text' => 'required|min:10',
            'price' => 'required|integer|max:999999999',
            'discount_price' => 'nullable|integer|max:999999999',
            'item_number' => 'integer',
        ];
    }

    public function messages(){
        return [
            'item_name.required' => '商品名を入力してください',
            'item_name.max' => '商品名は30文字以内で入力してください',
            'item_category.required' => 'アイテムカテゴリーを登録してください',
            'item_text.required' =>  '商品説明文を入力してください',
            'item_text.min' =>  '商品説明文は最低10文字以上入力してください',
            'price.required' => '価格を入力してください' ,
            'price.integer' => '価格は整数の数字で入力してください' ,
            'price.max' => '価格は10桁以内で入力してください' ,
            'discount_price.integer' => '値引き後価格は整数の数字で入力してください' ,
            'discount_price.max' => '値引き後価格は10桁以内で入力してください' ,
            'item_number.integer' => '在庫は整数の数字で入力してください' ,
        ];
    }
}
