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
        })->orderBy('created_at', 'desc');;
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
