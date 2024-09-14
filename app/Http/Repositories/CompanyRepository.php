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
     * @return @return Illuminate\Database\Eloquent\Builder
     */
    public function getAll()
    {
        return $this->company->query();
    }

    /**
     * @return Collection
     */
    public function getIdAndName(): Collection
    {
        return $this->company->select('id', 'name')->get();
    }

    /**
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function search(string $keyword)
    {
        return $this->company->where(function ($q) use($keyword) {
            $q->where('name', 'like', '%' . $keyword . '%');
            $q->orWhere('tel', 'like', '%' . $keyword . '%');
        })->orderBy('created_at', 'desc');
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
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
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
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function destroy($company_id)
    {
        try {
            DB::beginTransaction();
            $this->findByOne($company_id)
                ->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
