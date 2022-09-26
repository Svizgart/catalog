<?php

namespace App\Services\Product;

use App\Models\Category;

class ProductService
{
    const DEFAULT_PER_PAGE_ITEMS = 20;

    /**
     * @param Category $category
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getProduct(Category $category)
    {
        return $category->products()->orderBy('id', 'desc')->paginate(self::DEFAULT_PER_PAGE_ITEMS);
    }

}
