<?php

namespace App\Http\Services;

use App\Http\Repositories\CompanyRepository;
use App\Http\Repositories\PostingRepository;

class ViewListPostingService
{
    /**
     * @var PostingRepository
     */
    protected $postingRepository;
    /**
     * @var CompanyRepository
     */
    protected $companyRepository;

    public function __construct()
    {
        $this->postingRepository = new PostingRepository();
        $this->companyRepository = new CompanyRepository();
    }

    public function all()
    {
        return $this->postingRepository->getAll(['product', 'company'])->orderBy('created_at', 'desc');
    }

    public function search(string $keyword)
    {
        return $this->postingRepository->getAll(['product', 'company'])->where(function ($q) use($keyword) {
            $q->where('content', 'like', '%' . $keyword . '%');
            $q->orWhere('note', 'like', '%' . $keyword . '%');
        })->orWhereHas('company', function ($q) use ($keyword) {
            $q->where('name', 'like', '%' . $keyword . '%');
        })->orWhereHas('product', function ($q) use ($keyword) {
            $q->where('name', 'like', '%' . $keyword . '%');
        })->orderBy('created_at', 'desc');
    }

    /**
     * @param int
     * @return void
     */
    public function findByOne(int $product_id)
    {
        return $this->postingRepository->findByOne($product_id);
    }

    public function getCompanyData(int $company_id)
    {
        return $this->companyRepository->findByOne($company_id);
    }
}
