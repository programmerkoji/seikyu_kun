<?php

namespace App\Http\Requests;

use App\Models\Invoice;
use Illuminate\Foundation\Http\FormRequest;

class PaymentDetailRequest extends FormRequest
{
    protected $invoice;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function setInvoice($invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'payment_category_id' => ['required'],
            'payment_date' => ['required', 'date', 'date_format:Y-m-d'],
            'amount' => ['required', 'integer'],
        ];
    }

    public function messages()
    {
        return [
            'payment_category_id.required' => '入金区分を選択してください',
            'payment_date.required' => '入金日を入力してください',
            'amount.required' => '金額を入力してください',
            'payment_date.date' =>  '有効な日付形式で入力してください（例）2024-01-01',
            'amount.integer' =>  '半角の数字で入力してください',
        ];
    }
}
