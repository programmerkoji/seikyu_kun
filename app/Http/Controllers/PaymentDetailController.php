<?php

namespace App\Http\Controllers;

use App\Repositories\InvoiceRepository;
use App\Repositories\PaymentDetailRepository;
use App\Http\Requests\PaymentDetailRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentDetailController extends Controller
{
    /**
     * @var PaymentDetailRepository
     */
    protected $paymentDetailRepository;

    /**
     * @var InvoiceRepository
     */
    protected $invoiceRepository;

    public function __construct() {
        $this->paymentDetailRepository = new PaymentDetailRepository();
        $this->invoiceRepository = new InvoiceRepository();
    }

    public function store(PaymentDetailRequest $request)
    {
        $invoiceId = $request->input('invoice_id');
        $invoice = $this->invoiceRepository->findByOne($invoiceId, []);
        $paymentDate = Carbon::parse($request->input('payment_date'));
        $billingDate = Carbon::create($invoice->billing_year, $invoice->billing_month, 1);
        if ($paymentDate->lt($billingDate)) {
            return redirect()
                ->back()
                ->withErrors(['payment_date' => '入金日は請求日以降である必要があります'])
                ->withInput();
        }
        try {
            $this->paymentDetailRepository->create($request->toArray());
            return redirect()
            ->route('invoice.paymentDetails', ['invoice' => $invoice->id])
            ->with('message', '入金情報を登録しました');
        } catch (\Exception $e) {
            Log::channel('daily')->error('エラーメッセージ', [
                'exception' => $e,
            ]);
            return redirect()
                ->route('invoice.paymentDetailCreate', ['invoice' => $invoiceId])
                ->with('error', '処理が正しくできませんでした。');
        }
    }
}
