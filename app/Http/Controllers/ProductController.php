<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index()
    {
        $products = Product::with('user')->paginate(10);
        return response()->json($products);
    }

    /**
     * Store a newly created product.
     */
    public function store(ProductRequest $request)
    {
        $product = Auth::user()->products()->create($request->validated());

        return response()->json([
            'message' => 'Product created successfully.',
            'product' => $product
        ], 201);
    }

    /**
     * Display a specific product.
     */
    public function show(Product $product)
    {
        return response()->json($product);
    }

    /**
     * Update an existing product.
     */
    public function update(ProductRequest $request, Product $product)
    {
        if (Auth::id() !== $product->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $product->update($request->validated());

        return response()->json([
            'message' => 'Product updated successfully.',
            'product' => $product
        ]);
    }

    /**
     * Remove the specified product.
     */
    public function destroy(Product $product)
    {
        if (Auth::id() !== $product->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully.']);
    }
}
