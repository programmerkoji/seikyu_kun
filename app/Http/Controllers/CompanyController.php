<?php

namespace App\Http\Controllers;

use App\Repositories\CompanyRepository;
use App\Http\Requests\CompanyRequest;
use App\Http\Requests\ImportCsvRequest;
use App\Services\ViewListCompanyService;
use App\Imports\CompaniesImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        try {
            $this->companyRepository->create($request->toArray());
            return redirect()->route('company.index')->with('message', '企業を登録しました');
        } catch (\Exception $e) {
            Log::channel('daily')->error('エラーメッセージ', [
                'exception' => $e,
            ]);
            return back()->with('error', '請求データの登録に失敗しました。')->withInput();
        }
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
        try {
            $this->companyRepository->update($request->toArray(), $company_id);
            return redirect()
            ->route('company.index')
            ->with('message', '企業を編集しました');
        } catch (\Exception $e) {
            Log::channel('daily')->error('エラーメッセージ', [
                'exception' => $e,
            ]);
            return back()->with('error', '請求データの更新に失敗しました。')->withInput();
        }
    }

    /**
     * @param int $company_id
     */
    public function destroy(int $company_id)
    {
        try {
            $this->companyRepository->destroy($company_id);
            return redirect()
            ->route('company.index')
            ->with('message', '企業を削除しました');
        } catch (\Exception $e) {
            Log::channel('daily')->error('エラーメッセージ', [
                'exception' => $e,
            ]);
            return back()->with('error', '請求データの削除に失敗しました。');
        }
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
