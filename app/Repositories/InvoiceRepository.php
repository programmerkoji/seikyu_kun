<?php

namespace App\Repositories;

use App\Models\Invoice;
use App\Models\Posting;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InvoiceRepository
{
    /**
     * @var Invoice
     */
    protected $invoice;

    /**
     * @param Invoice
     */
    public function __construct()
    {
        $this->invoice = new Invoice();
    }

    /**
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAll(array $relations)
    {
        return $this->invoice->with($relations);
    }

    public function getDistinctYears()
    {
        return $this->invoice->selectRaw('DISTINCT billing_year')->orderBy('billing_year', 'desc')->pluck('billing_year');
    }

    public function getDistinctMonths()
    {
        return $this->invoice->selectRaw('DISTINCT billing_month')->orderBy('billing_month', 'asc')->pluck('billing_month');
    }

    /**
     * @return Collection
     */
    public function findByOne(int $invoice_id, array $relations): Invoice
    {
        return $this->invoice
            ->with($relations)
            ->findOrFail($invoice_id);
    }

    public function findByCompanyId(int $companyId)
    {
        return $this->invoice->where('company_id', $companyId);
    }

    public function findByIds(array $invoiceIds, array $relations)
    {
        return $this->invoice
            ->with($relations)
            ->whereIn('id', $invoiceIds);
    }

    public function create($data)
    {
        try {
            DB::beginTransaction();
            $invoice = new Invoice;
            $invoice->fill($data)->save();
            DB::commit();
            return $invoice;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
    public function update(array $data, $inovice_id, array $relations)
    {
        try {
            DB::beginTransaction();
            $this->findByOne($inovice_id, $relations)
                ->fill($data)
                ->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function destroy($inovice_id, array $relations)
    {
        try {
            DB::beginTransaction();
            $this->findByOne($inovice_id, $relations)
                ->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
