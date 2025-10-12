<?php

use Illuminate\Support\Facades\Route;
use Modules\Orders\Http\Controllers\OrdersController;

Route::middleware(['auth', 'role'])->group(function () {
    Route::get('dashboard/orders', [OrdersController::class, 'index'])
        ->name('dashboard.orders.index');
});


Route::middleware('auth')->post('/cart/create-order', [OrdersController::class, 'create'])->name('cart.createOrder');
Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrdersController::class, 'index'])->name('orders.index');
    Route::patch('/orders/update-status/{orderId}', [OrdersController::class, 'updateStatus'])->name('orders.update-status');
});

