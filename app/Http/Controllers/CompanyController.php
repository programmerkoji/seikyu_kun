<?php

namespace App\Http\Controllers;

use App\Http\Repositories\CompanyRepository;
use App\Http\Requests\CompanyRequest;
use App\Http\Requests\ImportCsvRequest;
use App\Http\Services\ViewListCompanyService;
use App\Imports\CompaniesImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CompanyController extends Controller
{
    /**
     * @var CompanyRepository
     */
    protected $companyRepository;

    /**
     * @var ViewListCompanyService
     */
    protected $viewListCompanyService;

    public function __construct()
    {
        $this->companyRepository = new CompanyRepository();
        $this->viewListCompanyService = new ViewListCompanyService();
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        if ($keyword) {
            $query = $this->viewListCompanyService->search($keyword);
        } else {
            $query = $this->viewListCompanyService->all();
        }
        $companies = $query->paginate(config('constants.pagination'))->withQueryString();
        return view('company.index', compact('companies'));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company.create');
    }

    /**
     * @param  \Illuminate\Http\CompanyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        $this->companyRepository->create($request->toArray());
        return redirect()->route('company.index')->with('message', '企業を登録しました');
    }

    /**
     * @param integer $company_id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(int $company_id)
    {
        $company = $this->companyRepository->findByOne($company_id);
        return view('company.edit', compact('company'));
    }

    /**
     * @param CompanyRequest $request
     * @param integer $company_id
     */
    public function update(CompanyRequest $request, int $company_id)
    {
        $this->companyRepository->update($request->toArray(), $company_id);
        return redirect()
        ->route('company.index')
        ->with('message', '企業を編集しました');
    }

    /**
     * @param int $company_id
     */
    public function destroy(int $company_id)
    {
        $this->companyRepository->destroy($company_id);
        return redirect()
        ->route('company.index')
        ->with('message', '企業を削除しました');
    }

    public function import(ImportCsvRequest $request)
    {
        $file = $request->file('file');
        try {
            Excel::import(new CompaniesImport, $file);
            return redirect()
                ->route('company.index')
                ->with('message', 'データが正常にインポートされました');
        } catch (\Exception $ex) {
            return redirect()
                ->route('company.create')
                ->with('error', 'データのインポート中にエラーが発生しました: ' . $ex->getMessage());
        }
    }
}
