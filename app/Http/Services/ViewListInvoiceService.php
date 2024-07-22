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
        return $this->invoiceRepository->getAll(['company'])->orderBy('created_at', 'desc');
    }

    public function search(string $keyword)
    {
        return $this->invoiceRepository->getAll(['company'])->where(function ($q) use($keyword) {
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

    public function existsPostingForInvoices($invoices)
    {
        $companyIds = $invoices->pluck('company_id');
        $invoiceYears = $invoices->pluck('billing_year');
        $invoiceMonths = $invoices->pluck('billing_month');

        $postings = $this->postingRepository->getPostingsForInvoices($companyIds, $invoiceYears, $invoiceMonths);
        $existsPostingForInvoices = array_fill_keys($invoices->pluck('id')->toArray(), false);
        $indexedPostings = [];
        foreach ($postings as $posting) {
            $year = (int)date('Y', strtotime($posting->posting_start));
            $month = (int)date('m', strtotime($posting->posting_start));
            $indexedPostings[$posting->company_id][$year][$month] = true;
        }
        foreach ($invoices as $invoice) {
            if (isset($indexedPostings[$invoice->company_id][$invoice->billing_year][$invoice->billing_month])) {
                $existsPostingForInvoices[$invoice->id] = true;
            }
        }
        return $existsPostingForInvoices;
    }
}
