<?php

namespace App\Http\Controllers\Api\v1\Product;

use App\Http\Requests\Product\{UpdateProductRequest, StoreProductRequest};
use App\Services\Product\ProductInteractionService;
use App\Http\Resources\Product\ProductResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Product;

final class ProductInteractionController extends Controller
{
    /**
     * @param ProductInteractionService $service
     */
    public function __construct(protected ProductInteractionService $service) {}

    /**
     * @param StoreProductRequest $request
     * @return ProductResource
     */
    public function store(StoreProductRequest $request): ProductResource
    {
        return new ProductResource($this->service->store($request));
    }

    /**
     * @param Product $product
     * @param UpdateProductRequest $request
     * @return ProductResource
     */
    public function update(Product $product, UpdateProductRequest $request): ProductResource
    {
         return new ProductResource($this->service->update($product, $request));
    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function delete(Product $product): JsonResponse
    {
        $product->categories()->detach();
        $product->delete();

        return response()->json(['success' => true]);
    }


}
