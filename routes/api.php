<?php

use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\BlogCategoryController;
use App\Http\Controllers\Api\Admin\BlogController;
use App\Http\Controllers\Api\Admin\FileManagerController;
use App\Http\Controllers\Api\Admin\ProductCategoryController;
use App\Http\Controllers\Api\Admin\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::prefix('admin')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('/product-categories', ProductCategoryController::class);
        Route::apiResource('/products', ProductController::class);
        Route::apiResource('/blog-categories', BlogCategoryController::class);
        Route::apiResource('/blogs', BlogController::class);
    });
    Route::prefix('directory')->group(function () {
        Route::get('/', [FileManagerController::class, 'getDirectory']);
        Route::post('files', [FileManagerController::class, 'storeFile']);
        Route::post('folder', [FileManagerController::class, 'createFolder']);
        Route::post('rename', [FileManagerController::class, 'renameFileAndFolder']);
        Route::post('file-folder', [FileManagerController::class, 'deleteFileAndFolder']);
    })->middleware('auth:sanctum');
});
