<?php

namespace App\Http\Controllers;

use App\Http\Repositories\PaymentDetailRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentDetailController extends Controller
{
    /**
     * @var PaymentDetailRepository
     */
    protected $paymentDetailRepository;

    public function __construct() {
        $this->paymentDetailRepository = new PaymentDetailRepository();
    }

    public function store(Request $request)
    {
        try {
            $this->paymentDetailRepository->create($request->toArray());
            return redirect()
            ->route('invoice.index')
            ->with('message', '入金情報を登録しました');
        } catch (\Exception $e) {
            Log::channel('daily')->error('エラーメッセージ', [
                'exception' => $e,
            ]);
            return redirect()
                ->route('invoice.paymentDetailCreate', ['invoice' => $request->input('invoice_id')])
                ->with('error', '処理が正しくできませんでした。');
        }
    }
}
