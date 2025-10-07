<?php

use Illuminate\Support\Facades\Route;
use Modules\Carts\Http\Controllers\CartsController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('carts', CartsController::class)->names('carts');
});
