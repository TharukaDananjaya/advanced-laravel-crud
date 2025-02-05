<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/products",
     *      operationId="getProducts",
     *      tags={"Products"},
     *      summary="Get list of products",
     *      description="Returns all products",
     *      security={{"sanctum":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *      )
     * )
     */
    public function index()
    {
        $products = Product::with('user')->paginate(10);
        return response()->json($products);
    }

    /**
     * @OA\Post(
     *      path="/api/product",
     *      operationId="createProduct",
     *      tags={"Products"},
     *      summary="Create a new product",
     *      description="Adds a new product",
     *      security={{"sanctum":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name","price","stock"},
     *              @OA\Property(property="name", type="string", example="New Product"),
     *              @OA\Property(property="description", type="string", example="Product description"),
     *              @OA\Property(property="price", type="number", format="float", example=100.50),
     *              @OA\Property(property="stock", type="integer", example=10)
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Product created successfully"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad request"
     *      )
     * )
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
     * @OA\Get(
     *      path="/api/product/{product}",
     *      operationId="getProduct",
     *      tags={"Products"},
     *      summary="Get specific product",
     *      description="Returns specific products",
     *      security={{"sanctum":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *      )
     * )
     */
    public function show(Product $product)
    {
        return response()->json($product);
    }

    /**
     * @OA\Put(
     *      path="/api/product/{product}",
     *      operationId="updateProduct",
     *      tags={"Products"},
     *      summary="Update a product",
     *      description="Update a product",
     *      security={{"sanctum":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name","price","stock"},
     *              @OA\Property(property="name", type="string", example="New Product"),
     *              @OA\Property(property="description", type="string", example="Product description"),
     *              @OA\Property(property="price", type="number", format="float", example=100.50),
     *              @OA\Property(property="stock", type="integer", example=10)
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Product updated successfully"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad request"
     *      )
     * )
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
     * @OA\Delete(
     *      path="/api/product/{product}",
     *      operationId="deleteProduct",
     *      tags={"Products"},
     *      summary="Delete specific product",
     *      description="Delete specific products",
     *      security={{"sanctum":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *      )
     * )
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
