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
        return [
            'name' => ['required', 'max:255'],
            'description' => ['required', 'max:1000'],
            'price' => ['required', 'integer'],
            'category_id' => ['required'],
            'image' => [
                'required', //必須
                'file', // ファイルがアップロードされている
                'image', // 画像ファイルである
                'mimes:jpeg,jpg,png', // 形式はjpegかpngのみ
                'dimensions:min_width=50,min_height=50,max_width=1000,max_height=1000', // 50*50 ~ 1000*1000 までのサイズ指定
            ]
        ];
    }
}
