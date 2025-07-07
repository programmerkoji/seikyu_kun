<?php

namespace App\Services;

use App\Repositories\Interfaces\ProductRepositoryInterface;

class ViewListProductService
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
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
