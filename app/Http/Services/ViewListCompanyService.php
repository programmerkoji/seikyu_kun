<?php

namespace App\Http\Services;

use App\Http\Repositories\CompanyRepository;

class ViewListCompanyService
{
    /**
     * @var CompanyRepository
     */
    protected $companyRepository;

    /**
     * @param CompanyRepository $procuctRepository
     */
    public function __construct()
    {
        $this->companyRepository = new CompanyRepository();
    }

    public function all()
    {
        return $this->companyRepository->getAll()->orderBy('created_at', 'desc');
    }

    public function search(string $keyword)
    {
        return $this->companyRepository->getAll()
            ->where(function ($q) use($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%');
                $q->orWhere('tel', 'like', '%' . $keyword . '%');
            })->orderBy('created_at', 'desc');
    }

    /**
     * @param int
     * @return void
     */
    public function findByOne(int $product_id)
    {
        return $this->companyRepository->findByOne($product_id);
    }
}
