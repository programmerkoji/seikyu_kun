<?php

namespace App\Http\Services;

use App\Http\Repositories\InvoiceRepository;

class ViewListInvoiceService
{
    /**
     * @var InvoiceRepository
     */
    protected $invoiceRepository;

    /**
     * @param InvoiceRepository $procuctRepository
     */
    public function __construct()
    {
        $this->invoiceRepository = new InvoiceRepository();
    }

    public function all()
    {
        return $this->invoiceRepository->getAll(['company']);
    }

    public function search(string $keyword)
    {
        return $this->invoiceRepository->search($keyword, ['product', 'company']);
    }

    /**
     * @param int
     */
    public function findByOne(int $invoice_id)
    {
        return $this->invoiceRepository->findByOne($invoice_id, ['company:id,name', 'company.postings:id,product_id,company_id,content,posting_start,posting_term,quantity,price,note']);
    }

    public function getPosting($invoice)
    {
        $invoiceYear = $invoice->billing_year;
        $invoiceMonth = $invoice->billing_month;
        $postings = [];
        foreach ($invoice->company->postings as $posting) {
            $postingYear = date('Y', strtotime($posting->posting_start));
            $postingMonth = date('m', strtotime($posting->posting_start));
            if ($invoiceYear === (int)$postingYear && $invoiceMonth === (int)$postingMonth) {
                $postings[] = $posting;
            }
        }
        return $postings;
    }
}
