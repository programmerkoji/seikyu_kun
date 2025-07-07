<?php

namespace App\Services;

use App\Repositories\ProductRepository;

class ViewListProductService
{
    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * @param ProductRepository $procuctRepository
     */
    public function __construct()
    {
        $this->productRepository = new ProductRepository();
    }

    /**
     * @return void
     */
    public function all()
    {
        return $this->productRepository->getAll();
    }

    /**
     * @param int
     * @return void
     */
    public function findByOne(int $product_id)
    {
        return $this->productRepository->findByOne($product_id);
    }
}
