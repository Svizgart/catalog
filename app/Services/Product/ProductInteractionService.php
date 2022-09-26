<?php

namespace App\Services\Product;

use App\Http\Requests\Product\StoreProductRequest;
use App\Services\Category\CategoryService;
use App\Traits\AddSlugTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Product;

class ProductInteractionService
{
    use AddSlugTrait;

    /**
     * @param CategoryService $categoryService
     */
    public function __construct(
        private CategoryService $categoryService
    ) {}

    /**
     * @param Request $request
     * @return Product
     */
    public function store(StoreProductRequest $request): Product
    {
        $request = $this->addSlug($request);

        $model = new Product;
        $model->fill($request->all());
        $model->save();

        $this->associateCategory($model, $request);

        return $model;
    }

    /**
     * @return Product
     */
    public function update(Product $product, Request $request): Product
    {
        $request = $this->addSlug($request);
        $product->fill($request->all())->save();

        $product->categories()->detach();
        $this->associateCategory($product, $request);

        return $product;
    }

    /**
     * @param Product $product
     * @param Request $request
     * @return void
     */
    private function associateCategory(Product $product, Request $request): void
    {
        $product->categories()->attach($this->idsCategory($request));
    }

    /**
     * @param Request $request
     * @return array
     */
    private function idsCategory(Request $request): array
    {
        $ids = [];
        $categories = $this->categoryService->getCategoryBySlugs($request->input('categories_slug'));

        foreach ($categories as $category) {
            $ids[] = $category->id;
        }

        return $ids;
    }
}
