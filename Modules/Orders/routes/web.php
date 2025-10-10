<?php

use Illuminate\Support\Facades\Route;
use Modules\Orders\Http\Controllers\OrdersController;

Route::middleware(['auth', 'role'])->group(function () {
    Route::get('dashboard/orders', [OrdersController::class, 'index'])
        ->name('dashboard.orders.index');
});
