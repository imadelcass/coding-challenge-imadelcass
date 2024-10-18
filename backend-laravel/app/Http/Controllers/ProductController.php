<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\ProductRequest;
use App\Services\ProductService;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $products = QueryBuilder::for(Product::class)
            ->with('categories:id,name')
            ->allowedFilters(['name', 'categories.id', 'price'])
            ->allowedSorts(['name', 'price'])
            ->paginate();

        return response()->json($products);
    }

    public function store(ProductRequest $request)
    {
        $product = $this->productService->create($request->validated());
        return response()->json($product, 201);
    }

    public function show(Product $product)
    {
        return response()->json($product);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $updatedProduct = $this->productService->update($product, $request->validated());
        return response()->json($updatedProduct);
    }

    public function destroy(Product $product)
    {
        $this->productService->delete($product);
        return response()->json(null, 204);
    }
}
