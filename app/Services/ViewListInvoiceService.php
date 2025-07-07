<?php

namespace App\Services;

use App\Repositories\CompanyRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\PostingRepository;

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
     * @var CompnayRepository
     */
    protected $companyRepository;

    /**
     * @param InvoiceRepository $invoiceRepository
     * @param PostingRepository $postingRepository
     * @param CompanyRepository $companyRepository
     */
    public function __construct()
    {
        $this->invoiceRepository = new InvoiceRepository();
        $this->postingRepository = new PostingRepository();
        $this->companyRepository = new CompanyRepository();
    }

    public function all()
    {
        return $this->invoiceRepository->getAll(['company', 'postings'])->orderBy('billing_year', 'desc')->orderBy('billing_month', 'desc');
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
        return $query->orderBy('billing_year', 'desc')->orderBy('billing_month', 'desc');
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
    public function findByOne(int $invoice_id, array $relations)
    {
        return $this->invoiceRepository->findByOne($invoice_id, $relations);
    }

    public function findByCompanyId(int $companyId)
    {
        return $this->invoiceRepository->findByCompanyId($companyId)->orderBy('billing_year', 'desc')->orderBy('billing_month', 'desc');
    }

    /**
     * @param array
     */
    public function findByIds(array $invoiceIds)
    {
        return $this->invoiceRepository->findByIds($invoiceIds, [
            'company:id,name', 'postings', 'postings.product'
        ]);
    }

    public function getCompanyInfoByPosting(int $companyId)
    {
        return $this->companyRepository->findByOne($companyId);
    }

    public function getStatusBgColors(object $invoices)
    {
        $statuses = $invoices->pluck('status')->toArray();
        $statusBgColors = [];
        foreach ($statuses as $status) {
            $statusBgColors[] = config('constants.statusBgColors')[$status];
        }
        return $statusBgColors;
    }
}
