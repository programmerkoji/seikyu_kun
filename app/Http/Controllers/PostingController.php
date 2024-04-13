<?php

namespace App\Http\Controllers;

use App\Http\Repositories\PostingRepository;
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

    public function __construct()
    {
        $this->postingRepository = new PostingRepository();
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
        $products = Product::select('id', 'name')->get();
        return view('posting.create', compact('companies', 'products'));
    }

    public function store(PostingRequest $request)
    {
        $this->postingRepository->create($request->toArray());
        return redirect()
        ->route('posting.index')
        ->with('message', '掲載を登録しました');
    }
}
