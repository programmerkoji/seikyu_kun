<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use App\Http\Requests\ProductRequest;
use App\Services\ViewListProductService;

class ProductController extends Controller
{
    /**
     * @var ViewListProductService
     * @var ProductRepository
     */
    public function __construct(
        protected ViewListProductService $viewListProductService,
        protected ProductRepository $productRepository
    )
    {}

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

    public function destroy(int $product_id)
    {
        $this->productRepository->destroy($product_id);
        return redirect()
        ->route('product.index')
        ->with('message', '商品を削除しました');
    }
}
