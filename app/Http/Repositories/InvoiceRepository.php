<?php

namespace App\Http\Repositories;

use App\Models\Invoice;
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
    /**
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function search(string $keyword, array $relations)
    {
        return $this->invoice->with($relations)->where(function ($q) use ($keyword) {
            $q->where('title', 'like', '%' . $keyword . '%');
            $q->orWhere('note', 'like', '%' . $keyword . '%');
        })->orWhereHas('company', function ($q) use ($keyword) {
            $q->where('name', 'like', '%' . $keyword . '%');
        })->orderBy('created_at', 'desc');
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

    public function create(array $data)
    {
        try {
            DB::beginTransaction();
            $invoice = new Invoice;
            $invoice->fill($data)->save();
            DB::commit();
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollback();
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
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollback();
        }
    }

    public function destroy($inovice_id, array $relations)
    {
        try {
            DB::beginTransaction();
            $this->findByOne($inovice_id, $relations)
                ->delete();
            DB::commit();
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollback();
        }
    }
}
