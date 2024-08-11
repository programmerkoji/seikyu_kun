<?php

namespace App\Http\Services;

use App\Http\Repositories\InvoiceRepository;
use App\Http\Repositories\PostingRepository;

class ViewListInvoiceService
{
    /**
     * @var InvoiceRepository
     */
    protected $invoiceRepository;
    /**
     * @var PostingRepository
     */
    protected $postingRepository;

    /**
     * @param InvoiceRepository $procuctRepository
     */
    public function __construct()
    {
        $this->invoiceRepository = new InvoiceRepository();
        $this->postingRepository = new PostingRepository();
    }

    public function all()
    {
        return $this->invoiceRepository->getAll(['company', 'postings'])->orderBy('created_at', 'desc');
    }

    public function search($searchYear, $searchMonth, $keyword)
    {
        $query = $this->invoiceRepository->getAll(['company', 'postings']);
        if ($keyword) {
            $query->where(function ($q) use($keyword) {
                $q->where('title', 'like', '%' . $keyword . '%');
                $q->orWhere('note', 'like', '%' . $keyword . '%');
            })->orWhereHas('company', function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%');
            });
        }
        if ($searchYear) {
            $query->where('billing_year', $searchYear);
        }
        if ($searchMonth) {
            $query->where('billing_month', $searchMonth);
        }
        return $query->orderBy('created_at', 'desc');
    }

    public function getDistinctYears()
    {
        return $this->invoiceRepository->getDistinctYears();
    }

    public function getDistinctMonths()
    {
        return $this->invoiceRepository->getDistinctMonths();
    }

    /**
     * @param int
     */
    public function findByOne(int $invoice_id)
    {
        return $this->invoiceRepository->findByOne($invoice_id, [
            'company:id,name', 'postings', 'postings.product'
        ]);
    }
}
