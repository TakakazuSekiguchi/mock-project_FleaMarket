<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'icon' => 'image|mimes:jpeg,png',
            'name' => 'required|max:20',
            'postal_code' => ['required', 'regex:/^\d{3}-\d{4}$/'],
            'address' => 'required',
        ];
    }

    public function messages(){
        return [
            'icon.image' => 'ユーザーアイコンは、画像を設定してください',
            'icon.mimes' => 'ユーザーアイコンの拡張子は、「.jpeg」、もしくは「.png」で設定してください',
            'name.required' => 'ユーザー名は、必須項目です',
            'name.max' => 'ユーザー名は、20文字以内で入力してください',
            'postal_code.required' => '郵便番号は、必須項目です',
            'postal_code.regex' => '郵便番号は、ハイフンを含む8文字で入力してください',
            'address.required' => '住所は、必須項目です',
        ];
    }
}
