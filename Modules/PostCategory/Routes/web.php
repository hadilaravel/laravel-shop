<?php

use Illuminate\Support\Facades\Route;
use Modules\PostCategory\Http\Controllers\PostCategoryController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('admin')->middleware([ 'auth' ,'role:admin'])->namespace('Admin')->group(function () {

Route::prefix('content')->middleware('role:ContentAdmin')->namespace('Content')->group(function () {
    //category
    Route::prefix('category')->group(function () {
        Route::get('/', [PostCategoryController::class, 'index'])->name('admin.content.category.index');
        Route::get('/create', [PostCategoryController::class, 'create'])->name('admin.content.category.create');
        Route::post('/store', [PostCategoryController::class, 'store'])->name('admin.content.category.store');
        Route::get('/edit/{postCategory}', [PostCategoryController::class, 'edit'])->name('admin.content.category.edit');
        Route::put('/update/{postCategory}', [PostCategoryController::class, 'update'])->name('admin.content.category.update');
        Route::delete('/destroy/{postCategory}', [PostCategoryController::class, 'destroy'])->name('admin.content.category.destroy');
        Route::get('/status/{postCategory}', [PostCategoryController::class, 'status'])->name('admin.content.category.status');
    });
});

});
