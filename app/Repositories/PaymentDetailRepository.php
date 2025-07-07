<?php

namespace App\Repositories;

use App\Models\PaymentDetail;
use App\Models\Posting;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentDetailRepository
{
    /**
     * @var PaymentDetail
     */
    protected $PaymentDetail;

    /**
     * @param PaymentDetail
     */
    public function __construct()
    {
        $this->PaymentDetail = new PaymentDetail();
    }

    public function create(array $data)
    {
        try {
            DB::beginTransaction();
            $paymentDetail = new PaymentDetail;
            $paymentDetail->fill($data)->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
