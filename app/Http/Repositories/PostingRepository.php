<?php

namespace App\Http\Repositories;

use App\Models\Posting;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PostingRepository
{
    /**
     * @var Posting
     */
    protected $posting;
    /**
     * @var Product
     */
    protected $product;

    /**
     * @param Posting
     * @param Product
     */
    public function __construct()
    {
        $this->posting = new Posting();
        $this->product = new Product();
    }

    /**
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAll()
    {
        return $this->posting->with('product')->orderBy('created_at', 'desc')->paginate(10);
    }

    /**
     * @return Collection
     */
    public function findByOne(int $product_id): Posting
    {
        return $this->product->findOrFail($product_id);
    }

    public function create(array $data)
    {
        try {
            DB::beginTransaction();
            $product = new Posting;
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
