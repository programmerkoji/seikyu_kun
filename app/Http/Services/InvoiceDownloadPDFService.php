<?php

namespace App\Http\Services;

use App\Http\Repositories\InvoiceRepository;

class InvoiceDownloadPDFService
{
    /**
     * @var InvoiceRepository
     */
    protected $invoiceRepository;

    public function __construct() {
        $this->invoiceRepository = new InvoiceRepository();
    }

    public function downloadPDF(int $invoice_id)
    {
        return $this->invoiceRepository->findByOne($invoice_id, ['company']);
        // dd($this->invoiceRepository->findByOne($invoice_id, []));
    }
}
