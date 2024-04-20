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
        return $this->posting->with('product')->orderBy('created_at', 'desc')->paginate(config('constants.pagination'));
    }

    /**
     * @return Collection
     */
    public function findByOne(int $posting_id): Posting
    {
        return $this->posting->with('product')->findOrFail($posting_id);
    }

    public function create(array $data)
    {
        try {
            DB::beginTransaction();
            $posting = new Posting;
            $posting->fill($data)->save();
            DB::commit();
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollback();
        }
    }

    public function update(array $data, $posting_id)
    {
        try {
            DB::beginTransaction();
            $this->findByOne($posting_id)
                ->fill($data)
                ->save();
            DB::commit();
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollback();
        }
    }

    public function destroy($posting_id)
    {
        try {
            DB::beginTransaction();
            $this->findByOne($posting_id)
                ->delete();
            DB::commit();
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollback();
        }
    }
}
