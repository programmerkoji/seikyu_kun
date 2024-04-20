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

    public function __construct()
    {
        $this->product = new Product();
    }

    /**
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAll()
    {
        return $this->product->paginate(config('constants.paginate'));
    }

    /**
     * @return Product
     */
    public function findByOne(int $product_id): Product
    {
        return $this->product->findOrFail($product_id);
    }

    /**
     * @return Collection
     */
    public function getIdAndName(): Collection
    {
        return $this->product->select('id', 'name')->get();
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
