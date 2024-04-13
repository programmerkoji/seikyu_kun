<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'base_price' => ['required', 'integer'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => '商品名は必須です。',
            'base_price.required' => '金額は必須です。',
            'base_price.integer' => '金額は半角の整数で入力してください。',
        ];
    }
}
