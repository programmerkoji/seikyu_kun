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

    public function createPostingWithInvoice(array $postingData, array $invoiceData)
    {
        DB::beginTransaction();
        try {
            $this->postingRepository->create($postingData);
            $this->invoiceRepository->create($invoiceData);
            DB::commit();
        } catch (Exception $e) {
            throw $e;
        }
    }
}
