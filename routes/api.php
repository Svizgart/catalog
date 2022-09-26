<?php

use App\Http\Controllers\Api\v1\Category\{CategoryController, CategoryInteractionController};
use App\Http\Controllers\Api\v1\Product\{ProductController, ProductInteractionController};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::namespace('Api\\v1')
    ->prefix('v1')
    ->group(function () {
        Route::get('categories', [CategoryController:: class, 'index'])->name('category.index');
        Route::get('products/{category:slug}', [ProductController:: class, 'index'])->name('product.index');

        Route::post('product/store', [ProductInteractionController::class, 'store'])
            ->middleware('format.price')
            ->name('product.store');
        Route::put('product/{product:slug}/update', [ProductInteractionController::class, 'update'])
            ->middleware('format.price')
            ->name('product.update');
        Route::delete('product/{product:slug}/delete', [ProductInteractionController::class, 'delete'])
            ->name('product.delete');

        Route::post('category/store', [CategoryInteractionController::class, 'store'])
            ->name('category.store');
        Route::put('category/{category:slug}update', [CategoryInteractionController::class, 'update'])
            ->name('category.update');
        Route::delete('category/{category:slug}/delete', [CategoryInteractionController::class, 'delete'])
            ->name('category.delete');
    });


