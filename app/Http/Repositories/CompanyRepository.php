<?php

namespace App\Http\Repositories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CompanyRepository
{
    /**
     * @var Company
     */
    protected $company;

    /**
     * @param Company
     * @param Product
     */
    public function __construct()
    {
        $this->company = new Company();
    }

    /**
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAll()
    {
        return $this->company->orderBy('created_at', 'desc')->paginate(config('constants.pagination'));
    }

    /**
     * @return Collection
     */
    public function findByOne(int $company_id): Company
    {
        return $this->company->findOrFail($company_id);
    }

    public function create(array $data)
    {
        try {
            DB::beginTransaction();
            $company = new Company;
            $company->fill($data)->save();
            DB::commit();
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollback();
        }
    }

    public function update(array $data, $company_id)
    {
        try {
            DB::beginTransaction();
            $this->findByOne($company_id)
                ->fill($data)
                ->save();
            DB::commit();
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollback();
        }
    }

    public function destroy($company_id)
    {
        try {
            DB::beginTransaction();
            $this->findByOne($company_id)
                ->delete();
            DB::commit();
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollback();
        }
    }
}
