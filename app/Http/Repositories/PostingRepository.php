<?php

namespace App\Http\Repositories;

use App\Models\Posting;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PostingRepository
{
    /**
     * @var Posting
     */
    protected $posting;
    /**
     * @var Product
     */
    protected $product;

    /**
     * @param Posting
     * @param Product
     */
    public function __construct()
    {
        $this->posting = new Posting();
        $this->product = new Product();
    }

    /**
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function getAll(array $relations)
    {
        return $this->posting->with($relations);
    }

    /**
     * @param array $companyIds
     * @param array $invoiceYears
     * @param array $invoiceMonths
     * @return Collection
     */
    public function getPostingsForInvoices($companyIds, $invoiceYears, $invoiceMonths, $relations)
    {
        return $this->posting->with($relations)->whereIn('company_id', $companyIds)
            ->whereIn(DB::raw('YEAR(posting_start)'), $invoiceYears)
            ->whereIn(DB::raw('MONTH(posting_start)'), $invoiceMonths)
            ->get();
    }

    /**
     * @return Collection
     */
    public function findByOne(int $posting_id): Posting
    {
        return $this->posting->with('product')->findOrFail($posting_id);
    }

    public function create(array $data)
    {
        try {
            DB::beginTransaction();
            $posting = new Posting;
            $posting->fill($data)->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(array $data, $posting_id)
    {
        try {
            DB::beginTransaction();
            $this->findByOne($posting_id)
                ->fill($data)
                ->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function destroy($posting_id)
    {
        try {
            DB::beginTransaction();
            $this->findByOne($posting_id)
                ->delete();
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }
}
