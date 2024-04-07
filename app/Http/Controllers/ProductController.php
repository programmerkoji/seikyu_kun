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
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $products = $this->viewListProductService->all();
        return view('products.index', compact('products'));
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
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

    public function edit(int $product_id)
    {
        $product = $this->viewListProductService->findByOne($product_id);
        return view('products.edit', compact('product'));
    }

    public function update(ProductRequest $request, int $product_id)
    {
        $this->productRepository->update($request->toArray(), $product_id);
        return redirect()
        ->route('product.index')
        ->with('message', '商品を編集しました');
    }
}
