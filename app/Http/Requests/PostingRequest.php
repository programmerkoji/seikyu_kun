<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostingRequest extends FormRequest
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
            'company_id' => ['required'],
            'product_id' => ['required'],
            'posting_term' => ['required', 'integer'],
            'posting_start' => ['required', 'date'],
            'quantity' => ['required', 'integer'],
            'quantity' => ['required', 'integer'],
            'price' => ['required', 'integer'],
            'content' => ['required', 'max:30'],
        ];
    }

    public function messages(): array
    {
        return [
            'company_id.required' => '企業を選択してください。',
            'product_id.required' => '商品を選択してください。',
            'posting_term.required' => '期間を入力してください。',
            'posting_term.integer' => '期間は半角の数字で入力してください。',
            'posting_start.required' => '掲載開始日を入力してください。',
            'posting_start.required' => '掲載開始日は日付形式で入力してください。',
            'quantity.required' => '数量を入力してください。',
            'quantity.integer' => '数量は半角の数字で入力してください。',
            'price.required' => '金額を入力してください。',
            'price.integer' => '金額は半角の数字で入力してください。',
            'content.required' => '掲載内容を入力してください。',
            'content.max' => '掲載内容は30文字以内で入力してください。',
        ];
    }
}
