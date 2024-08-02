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

    public function search(string $keyword)
    {
        return $this->invoiceRepository->getAll(['company', 'postings'])->where(function ($q) use($keyword) {
            $q->where('title', 'like', '%' . $keyword . '%');
            $q->orWhere('note', 'like', '%' . $keyword . '%');
        })->orWhereHas('company', function ($q) use ($keyword) {
            $q->where('name', 'like', '%' . $keyword . '%');
        })->orderBy('created_at', 'desc');
    }

    /**
     * @param int
     */
    public function findByOne(int $invoice_id)
    {
        return $this->invoiceRepository->findByOne($invoice_id, ['company:id,name', 'company.postings:id,product_id,company_id,content,posting_start,posting_term,quantity,price,note']);
    }

    public function getPostingForInvoice($invoice)
    {
        $companyId = [$invoice->company_id];
        $invoiceYear = [$invoice->billing_year];
        $invoiceMonth = [$invoice->billing_month];
        $postings = $this->postingRepository->getPostingsForInvoices($companyId, $invoiceYear, $invoiceMonth, 'product');
        return $postings;
    }
}
