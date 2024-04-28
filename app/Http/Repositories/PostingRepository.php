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
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function getAll()
    {
        return $this->posting->with('product', 'company')->orderBy('created_at', 'desc');
    }
    /**
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function search(string $keyword)
    {
        return $this->posting->with('product', 'company')->where(function ($q) use($keyword) {
            $q->where('content', 'like', '%' . $keyword . '%');
            $q->orWhere('note', 'like', '%' . $keyword . '%');
        })->orWhereHas('company', function ($q) use ($keyword) {
            $q->where('name', 'like', '%' . $keyword . '%');
        })->orWhereHas('product', function ($q) use ($keyword) {
            $q->where('name', 'like', '%' . $keyword . '%');
        })->orderBy('created_at', 'desc');
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
