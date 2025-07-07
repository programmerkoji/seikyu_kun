<?php

namespace App\Http\Controllers;

use App\Repositories\CompanyRepository;
use Illuminate\Http\Request;

class AutocompleteController extends Controller
{
    /**
     * @var CompanyRepository
     */
    protected $companyRepository;

    public function __construct(CompanyRepository $companyRepository) {
        $this->companyRepository = $companyRepository;
    }

    public function company(Request $request)
    {
        $query = $request->get('query', '');
        $results = $this->companyRepository->getAll()
            ->select(['id', 'name'])
            ->where('name', 'like', '%' . $query . '%')
            ->get();
        return response()->json($results);
    }
}
