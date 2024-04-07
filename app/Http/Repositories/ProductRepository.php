<?php

namespace App\Http\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductRepository
{
    /**
     * @var Product
     */
    protected $product;

    /**
     * @param Product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * すべて取得
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->product->get();
    }

    public function create(array $data)
    {
        try {
            DB::beginTransaction();
                $product = new Product;
                $product->fill($data)->save();
            DB::commit();
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollback();
        }
    }
}
