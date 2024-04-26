<?php

namespace App\Http\Services;

use App\Http\Repositories\PostingRepository;

class ViewListPostingService
{
    /**
     * @var PostingRepository
     */
    protected $postingRepository;

    /**
     * @param PostingRepository $procuctRepository
     */
    public function __construct()
    {
        $this->postingRepository = new PostingRepository();
    }

    public function all()
    {
        return $this->postingRepository->getAll();
    }

    public function search(string $keyword)
    {
        return $this->postingRepository->search($keyword);
    }

    /**
     * @param int
     * @return void
     */
    public function findByOne(int $product_id)
    {
        return $this->postingRepository->findByOne($product_id);
    }
}
