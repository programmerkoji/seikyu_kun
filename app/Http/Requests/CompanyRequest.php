<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => ['required'],
            'post_code' => ['required'],
            'address' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '企業名は必須項目です。',
            'post_code.required' => '郵便番号は必須項目です。',
            'address.required' => '住所は必須項目です。',
        ];
    }
}
