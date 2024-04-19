<?php

namespace App\Http\Controllers;

use App\Http\Repositories\PostingRepository;
use App\Http\Repositories\ProductRepository;
use App\Http\Requests\PostingRequest;
use App\Models\Company;
use App\Models\Product;
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

    public function __construct()
    {
        $this->postingRepository = new PostingRepository();
        $this->productRepository = new ProductRepository();
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $postings = $this->postingRepository->getAll();
        return view('posting.index', compact('postings'));
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $companies = Company::select('id', 'name')->get();
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
        $companies = Company::select('id', 'name')->get();
        return view('posting.edit', compact('posting', 'products', 'companies'));
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
}
