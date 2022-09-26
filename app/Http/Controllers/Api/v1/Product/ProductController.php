<?php

namespace App\Http\Controllers\Api\v1\Product;

use App\Http\Resources\Product\ProductCollection;
use App\Services\Product\ProductService;
use App\Http\Controllers\Controller;
use App\Models\Category;

final class ProductController extends Controller
{
    /**
     * @param ProductService $service
     */
    public function __construct(protected ProductService $service) {}

    /**
     * @param Category $category
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Category $category)
    {
        return ProductCollection::collection($this->service->getProduct($category));
    }
}
