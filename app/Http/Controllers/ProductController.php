<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Http\Resources\ProductResource;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $service)
    {
        $this->productService = $service;
    }

    /**
     * List all products
     *
     * Returns a list of all available products with basic details.
     *
     * @group Products
     *
     * @response 200 {
     *   "data": [
     *     {
     *       "id": 1,
     *       "name": "Test Product",
     *       "price": "2.00",
     *       "description": "A test product",
     *       "stock": 6
     *     },
     *     {
     *       "id": 7,
     *       "name": "Test Product 2",
     *       "price": "3.00",
     *       "description": "A test product",
     *       "stock": 12
     *     }
     *   ]
     * }
     */

    public function index()
    {
        $products = $this->productService->list();
        return ProductResource::collection($products);
    }

        /**
     * Add a new product (admin only)
     *
     * @group Products
     * 
     * @authenticated
     * 
     * @bodyParam name string required Name of the product. Example: Laptop
     * @bodyParam description string Description of the product. Example: Fast gaming laptop
     * @bodyParam price number required Price of the product. Example: 999.99
     * @bodyParam stock integer required Stock quantity. Example: 10
     *
     * @response 201 {
      *      "data": {
      *          "id": 8,
      *          "name": "Test Product 2",
      *          "price": 99.99,
      *          "description": "A test product",
      *          "stock": 10
      *     }
      * }
     */

    public function store(StoreProductRequest $request)
    {
        $product = $this->productService->create($request->validated());

        return new ProductResource($product);
    }

        /**
     * Update a product (admin only)
     *
     * @group Products
     * 
     * @authenticated
     * 
     * @urlParam id integer required The ID of the product. Example: 1
     * @bodyParam name string required Name of the product. Example: Laptop Pro
     * @bodyParam description string Description of the product. Example: Updated fast gaming laptop
     * @bodyParam price number required Price of the product. Example: 1299.99
     * @bodyParam stock integer required Stock quantity. Example: 5
     *
     * @response 200 {
     *       "data": {
     *      "id": 7,
     *     "name": "Updated Product Name",
     *     "price": 50,
     *     "description": "A test product",
     *     "stock": 22
     *    }
     * }
     */

    public function update(UpdateProductRequest $request, $id)
    {
        $product = $this->productService->update($id, $request->validated());
        return new ProductResource($product);
    }

        /**
     * Delete a product (admin only)
     *
     * @group Products
     * 
     * @authenticated
     * 
     * @urlParam id integer required The ID of the product. Example: 1
     *
     * @response 200 {
     *   "message": "Product deleted"
     * }
     */

    public function destroy($id)
    {
        $this->productService->delete($id);
        return response()->json(['message' => 'Product deleted']);
    }
}
