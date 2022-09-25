<?php

use App\Http\Controllers\Api\v1\Category\{CategoryController, CategoryInteractionController};
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
        Route::get('category', [CategoryController:: class, 'index'])->name('category.index');

        Route::post('category/store', [CategoryInteractionController::class, 'store'])
            ->name('category.store');
        Route::put('category/{category}update', [CategoryInteractionController::class, 'update'])
            ->name('category.update');
        Route::delete('category/{category}/delete', [CategoryInteractionController::class, 'delete'])
            ->name('category.delete');
    });


