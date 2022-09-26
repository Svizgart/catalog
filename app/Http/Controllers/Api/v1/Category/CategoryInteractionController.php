<?php

namespace App\Http\Controllers\Api\v1\Category;

use App\Http\Requests\Category\{UpdateCategoryRequest, StoreCategoryRequest};
use App\Services\Category\CategoryInteractionService;
use App\Http\Resources\Category\CategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Category;

final class CategoryInteractionController extends Controller
{
    public function __construct(protected CategoryInteractionService $service) { }

    public function store(StoreCategoryRequest $request): ?JsonResource
    {
        return new CategoryResource($this->service->store($request));
    }

    public function update(Category $category, UpdateCategoryRequest $request): ?JsonResource
    {
        $category = $this->service->update($request, $category);

        return new CategoryResource($category);
    }

    public function delete(Category $category): ?JsonResponse
    {
        $category->products()->detach();
        $category->delete();

        return response()->json(['success' => true]);
    }
}
