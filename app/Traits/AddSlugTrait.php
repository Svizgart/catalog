<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait AddSlugTrait
{
    /**
     * @param Request $request
     * @return Request
     */
    private function addSlug(Request $request): Request
    {
        return $request->merge([
            'slug' => Str::slug($request->input('name')),
        ]);
    }
}
