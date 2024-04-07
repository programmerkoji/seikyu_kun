<?php

namespace App\Http\Services;

use App\Http\Repositories\ProductRepository;

class ViewListProductService
{
    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * @param ProductRepository $procuctRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     *
     *
     * @return void
     */
    public function all()
    {
        return $this->productRepository->getAll();
    }
}
