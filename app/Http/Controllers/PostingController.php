<?php

namespace App\Http\Controllers;

use App\Repositories\CompanyRepository;
use App\Repositories\PostingRepository;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Http\Requests\PostingRequest;
use App\Services\PostingInvoiceService;
use App\Services\ViewListPostingService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostingController extends Controller
{
    /**
     * @var PostingRepository
     */
    protected $postingRepository;
    /**
     * @var ProductRepositoryInterface
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
    /**
     * @var PostingInvoiceService
     */
    protected $postingInvoiceService;

    public function __construct()
    {
        $this->postingRepository = new PostingRepository();
        $this->productRepository = new ProductRepositoryInterface();
        $this->companyRepository = new CompanyRepository();
        $this->viewListPostingService = new ViewListPostingService();
        $this->postingInvoiceService = new PostingInvoiceService();
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        session()->forget('postingData');
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
        $validatedData = $request->validated();
        try {
            $postingData = [
                'company_id' => $validatedData['company_id'],
                'product_id' => $validatedData['product_id'],
                'posting_term' => $validatedData['posting_term'],
                'posting_start' => $validatedData['posting_start'],
                'quantity' => $validatedData['quantity'],
                'content' => $validatedData['content'],
                'price' => $validatedData['price'],
                'note' => $request->input('note'),
            ];
            session(['postingData' => $postingData]);
            return redirect()->route('invoice.create');
        } catch (Exception $e) {
            Log::channel('daily')->error('エラーメッセージ', [
                'exception' => $e,
            ]);
            return redirect()
                ->route('posting.create')
                ->with('error', '処理が正しくできませんでした。');
        }
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
