<?php

namespace App\Http\Controllers;

use App\Http\Repositories\CompanyRepository;
use App\Http\Repositories\PostingRepository;
use App\Http\Repositories\ProductRepository;
use App\Http\Requests\PostingRequest;
use App\Http\Services\ViewListPostingService;
use Illuminate\Http\Request;

class PostingController extends Controller
{
    /**
     * @var PostingRepository
     */
    protected $postingRepository;
    /**
     * @var ProductRepository
     */
    protected $productRepository;
    /**
     * @var CompanyRepository
     */
    protected $companyRepository;
    /**
     * @var ViewListPostingService
     */
    protected $viewListPostingService;

    public function __construct()
    {
        $this->postingRepository = new PostingRepository();
        $this->productRepository = new ProductRepository();
        $this->companyRepository = new CompanyRepository();
        $this->viewListPostingService = new ViewListPostingService();
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        if ($keyword) {
            $query = $this->viewListPostingService->search($keyword);
        } else {
            $query = $this->viewListPostingService->all();
        }
        $postings = $query->paginate(config('constants.pagination'))->withQueryString();
        return view('posting.index', compact('postings'));
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $companies = $this->companyRepository->getIdAndName();
        $products = $this->productRepository->getIdAndName();
        return view('posting.create', compact('companies', 'products'));
    }

    /**
     * @param PostingRequest $request
     */
    public function store(PostingRequest $request)
    {
        $this->postingRepository->create($request->toArray());
        return redirect()
        ->route('posting.index')
        ->with('message', '掲載を登録しました');
    }

    /**
     * @param integer $posting_id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(int $posting_id)
    {
        $posting = $this->postingRepository->findByOne($posting_id);
        $products = $this->productRepository->getIdAndName();
        // $companies = $this->companyRepository->getIdAndName();
        $companyData = $this->viewListPostingService->getCompanyData($posting->company_id);
        return view('posting.edit', compact('posting', 'products', 'companyData'));
    }

    /**
     * @param PostingRequest $request
     * @param integer $posting_id
     */
    public function update(PostingRequest $request, int $posting_id)
    {
        $this->postingRepository->update($request->toArray(), $posting_id);
        return redirect()
        ->route('posting.index')
        ->with('message', '掲載を編集しました');
    }

    /**
     * @param int $posting_id
     */
    public function destroy(int $posting_id)
    {
        $this->postingRepository->destroy($posting_id);
        return redirect()
        ->route('posting.index')
        ->with('message', '掲載を削除しました');
    }
}
