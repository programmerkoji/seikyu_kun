<?php

namespace App\Http\Controllers;

use App\Http\Repositories\ProductRepository;
use App\Http\Requests\ProductRequest;
use App\Http\Services\ViewListProductService;

class ProductController extends Controller
{
    /**
     * @var ViewListProductService
     */
    protected $viewListProductService;
    protected $productRepository;

    /**
     * @param ViewListProductService $viewListProductService
     */
    public function __construct(ViewListProductService $viewListProductService, ProductRepository $productRepository)
    {
        $this->viewListProductService = $viewListProductService;
        $this->productRepository = $productRepository;
    }

    /**
     * 製品一覧
     * @param
     */
    public function index()
    {
        $products = $this->viewListProductService->all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(ProductRequest $request)
    {
        $this->productRepository->create($request->toArray());
        return redirect()
        ->route('product.index')
        ->with('message', '商品を登録しました');
    }
}
