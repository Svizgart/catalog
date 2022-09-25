<?php

namespace App\Services\Category;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

final class CategoryInteractionService
{
    /**
     * @param Request $request
     * @return Category|null
     */
    public function store(Request $request): ?Category
    {
        $request->merge([
            'slug' => Str::slug($request->input('name')),
        ]);

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
        $request->merge([
            'slug' => Str::slug($request->input('name')),
        ]);

        $category->fill($request->all())->save();

        return $category;
    }

}
