<?php

namespace App\Services\Category;

use App\Traits\AddSlugTrait;
use Illuminate\Http\Request;
use App\Models\Category;

final class CategoryInteractionService
{
    use AddSlugTrait;
    /**
     * @param Request $request
     * @return Category|null
     */
    public function store(Request $request): ?Category
    {
        $request = $this->addSlug($request);

        $category = new Category;
        $category->fill($request->all());
        $category->save();

        return $category;
    }

    /**
     * @param Request $request
     * @param Category $category
     * @return Category|null
     */
    public function update(Request $request, Category $category): ?Category
    {
        $request = $this->addSlug($request);

        $category->fill($request->all())->save();

        return $category;
    }

}
