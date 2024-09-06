<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $companyId = (int)$this->route('company');
        return [
            'name' => ['required', Rule::unique('companies')->ignore($companyId)],
            'post_code' => ['required'],
            'address' => ['required'],
            'tel' => ['required'],
            'ceo_name' => ['required'],
            'responsible_person_name' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '企業名は必須項目です。',
            'name.unique' => 'すでに登録されています。',
            'post_code.required' => '郵便番号は必須項目です。',
            'address.required' => '住所は必須項目です。',
            'tel.required' => '電話番号は必須項目です。',
            'ceo_name.required' => '代表者名は必須項目です。',
            'responsible_person_name.required' => '担当者名は必須項目です。',
        ];
    }
}
