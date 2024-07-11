<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
            'company_id' => ['required'],
            'title' => ['required', 'max:30'],
            'billing_year' => ['required'],
            'billing_month' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'company_id.required' => '企業名を入力してください。',
            'title.required' => '請求タイトルを入力してください。',
            'title.max' => '請求タイトルは30文字以内で入力してください。',
            'billing_year.required' => '請求年を入力してください。',
            'billing_month.required' => '請求月を選択してください。',
        ];
    }
}
