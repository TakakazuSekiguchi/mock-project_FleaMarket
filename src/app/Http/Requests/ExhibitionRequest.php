<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
        return [
            'image' => 'image|mimes:jpeg,png',
            'category_ids'   => 'required|array|min:1',
            'category_ids.*' => 'integer|exists:categories,id',
            'condition' => 'required|integer|between:1,4',
            'name' => 'required|max:20',
            'description' => 'required|max:255',
            'price' => 'required|integer|min:0',
        ];
    }

    public function messages(){
        return [
            'image.image' => '商品画像は、画像を設定してください',
            'image.mimes' => '商品画像の拡張子は、「.jpeg」、もしくは「.png」で設定してください',
            'category_ids.required' => 'カテゴリーは、必須項目です',
            'category_ids.min'      => 'カテゴリーを1つ以上選択してください。',
            'category_ids.*.exists' => '不正なカテゴリーが選択されています。',
            'condition.required' => '商品の状態は、必須項目です',
            'name.required' => '商品名は、必須項目です',
            'description.required' => '商品説明は、必須項目です',
            'description.max' => '商品説明は、255文字以内で入力してください',
            'price.required' => '販売価格は、必須項目です',
            'price.integer' => '販売価格は、数値を入力してください',
            'price.min' => '販売価格は、0円以上で入力してください',
        ];
    }
}
