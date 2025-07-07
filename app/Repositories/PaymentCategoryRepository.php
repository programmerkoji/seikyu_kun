<?php

namespace App\Repositories;

use App\Models\PaymentCategory;
use App\Models\Posting;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentCategoryRepository
{
    /**
     * @var PaymentCategory
     */
    protected $PaymentCategory;

    /**
     * @param PaymentCategory
     */
    public function __construct()
    {
        $this->PaymentCategory = new PaymentCategory();
    }

    /**
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAll()
    {
        return $this->PaymentCategory->all();
    }
}
