<?php

use Illuminate\Support\Facades\Route;
use Modules\Products\Http\Controllers\ProductsController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('products', ProductsController::class)->names('products');
});

Route::prefix('dashboard/products')->name('dashboard.products.')->group(function () {
    Route::get('/', [ProductsController::class, 'index'])->name('index');
    Route::get('/create', [ProductsController::class, 'create'])->name('create');
    Route::post('/', [ProductsController::class, 'store'])->name('store');
    Route::get('/{product}/edit', [ProductsController::class, 'edit'])->name('edit');
    Route::put('/{product}', [ProductsController::class, 'update'])->name('update');
    Route::delete('/{product}', [ProductsController::class, 'destroy'])->name('destroy');
});


