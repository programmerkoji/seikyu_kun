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
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->product->get();
    }

    /**
     * @return Collection
     */
    public function findByOne(int $product_id): Product
    {
        return $this->product->findOrFail($product_id);
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

    public function update(array $data, $product_id)
    {
        try {
            DB::beginTransaction();
            $this->findByOne($product_id)
                ->fill($data)
                ->save();
            DB::commit();
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollback();
        }
    }

    public function destroy($product_id)
    {
        try {
            DB::beginTransaction();
            $this->findByOne($product_id)
                ->delete();
            DB::commit();
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollback();
        }
    }
}
