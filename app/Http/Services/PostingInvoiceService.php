<?php

namespace App\Http\Services;

use App\Http\Repositories\CompanyRepository;
use App\Http\Repositories\InvoiceRepository;
use App\Http\Repositories\PostingRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class PostingInvoiceService
{
    /**
     * @var PostingRepository
     */
    protected $postingRepository;
    /**
     * @var CompanyRepository
     */
    protected $companyRepository;
    /**
     * @var InvoiceRepository
     */
    protected $invoiceRepository;

    public function __construct()
    {
        $this->postingRepository = new PostingRepository();
        $this->companyRepository = new CompanyRepository();
        $this->invoiceRepository = new InvoiceRepository();
    }

    public function createPostingWithInvoice($request)
    {
        DB::beginTransaction();
        try {
            $postingData = session('postingData');
            $selectedInvoiceId = $request['selectedInvoiceId'] ?? null;
            $invoiceData = $request['invoice'] ?? null;
            if ($selectedInvoiceId) {
                $postingData['invoice_id'] = $selectedInvoiceId;
                $this->postingRepository->create($postingData);
            } else {
                $invoiceData['company_id'] = $postingData['company_id'];
                $invoice = $this->invoiceRepository->create($invoiceData);
                $postingData['invoice_id'] = $invoice->id;
                $this->postingRepository->create($postingData);
            }
            DB::commit();
            session()->forget('posting_data');
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
