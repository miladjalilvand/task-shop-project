<?php

use Illuminate\Support\Facades\Route;
use Modules\Carts\Http\Controllers\CartsController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('carts', CartsController::class)->names('carts');
});
