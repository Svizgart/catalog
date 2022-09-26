<?php

namespace App\Services\Category;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

final class CategoryService
{
    const DEFAULT_PER_PAGE_ITEMS = 20;

    public function __construct(private Category $model) {}

    /**
     * @return mixed
     */
    public function getCategoriesPage()
    {
        return $this->model::orderBy('id', 'desc')->paginate($this::DEFAULT_PER_PAGE_ITEMS);
    }

    /**
     * @param array $slug
     * @return Collection|null
     */
    public function getCategoryBySlugs(array $slug): ?Collection
    {
        return $this->model::whereIn('slug', $slug)->get();
    }

}
