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
        return $this->invoiceRepository->getAll();
    }

    public function search(string $keyword)
    {
        return $this->invoiceRepository->search($keyword);
    }

    /**
     * @param int
     * @return void
     */
    public function findByOne(int $invoice_id)
    {
        return $this->invoiceRepository->findByOne($invoice_id);
    }
}
