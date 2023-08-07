<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->query('q');
        $categoryId = $request->query('category_id');
        $isActive = $request->query('is_active');
        $sortPrice = $request->query('sort_price');
        $pageSize = $request->query('page_size') ?? 10;

        $product = Product::where('name','like','%'.$q.'%');

        if($isActive){
            $product = $product->where('is_active',filter_var($isActive, FILTER_VALIDATE_BOOLEAN));
        }

        if($categoryId){
            $product = $product->where('category_id',$categoryId);
        }

        if($sortPrice){
            $product = $product->orderBy('price', $sortPrice);
        }else {
            $product = $product->orderBy('id', 'DESC');
        }

        return ProductResource::collection($product->paginate($pageSize));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());

        return ProductResource::make($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return ProductResource::make($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->noContent();
    }
}
