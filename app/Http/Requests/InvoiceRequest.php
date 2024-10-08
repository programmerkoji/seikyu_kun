<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
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
        if ($this->isMethod('post')) {
            $selectedInvoiceId = $this->input('selectedInvoiceId');
            $invoice = $this->input('invoice');
            if (($selectedInvoiceId && !empty(array_filter($invoice))) || (!$selectedInvoiceId && empty(array_filter($invoice)))) {
                return [];
            }
            if (!empty(array_filter($invoice))) {
                return [
                    'invoice.title' => ['required', 'max:30'],
                    'invoice.billing_year' => ['required'],
                    'invoice.billing_month' => ['required'],
                ];
            }
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $invoiceId = $this->route('invoice');
            return [
                'title' => [
                    'required',
                    'max:30',
                    function ($attribute, $value, $fail) use ($invoiceId) {
                        $existsInvoiceId = \App\Models\Invoice::find($invoiceId)->title;
                        if ($value !== $existsInvoiceId && empty($value)) {
                            $fail('請求タイトルは必須です。');
                        }
                    }
                ],
            ];
        }
        return [];
    }

    public function messages()
    {
        return [
            'invoice.title.required' => '請求タイトルを入力してください。',
            'invoice.title.max' => '請求タイトルは30文字以内で入力してください。',
            'invoice.billing_year.required' => '請求年を入力してください。',
            'invoice.billing_month.required' => '請求月を選択してください。',
            'selectedInvoiceId.invoice_conflict' => '①、②のどちらか一方を指定してください。',
            'title.required' => '請求タイトルは必須です。',
            'title.max' => '請求タイトルは30文字以内で入力してください。',
        ];
    }

    protected function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $selectedInvoiceId = $this->input('selectedInvoiceId');
            $invoice = $this->input('invoice');

            if ($this->isMethod('post')) {
                if (($selectedInvoiceId && !empty(array_filter($invoice))) || (!$selectedInvoiceId && empty(array_filter($invoice)))) {
                    $validator->errors()->add('selectedInvoiceId', '①、②のどちらか一方を指定してください。');
                }
            }
        });
    }
}
