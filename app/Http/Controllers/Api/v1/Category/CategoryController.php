<?php

namespace App\Http\Controllers\Api\v1\Category;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Category\CategoryCollection;
use App\Services\Category\CategoryService;
use App\Http\Controllers\Controller;

final class CategoryController extends Controller
{
    public function __construct(protected CategoryService $service) {}

    public function index(): ?ResourceCollection
    {
        return CategoryCollection::collection($this->service->getCategoriesPage());
    }
}
