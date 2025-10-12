<?php

use Illuminate\Support\Facades\Route;
use Modules\Carts\Http\Controllers\CartsController;
use Modules\Orders\Http\Controllers\OrdersController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('carts', CartsController::class)->names('carts');
});



Route::middleware('auth')->post('/add-to-cart',[CartsController::class,'addToCart'])->name('addToCart');
Route::middleware('auth')->get('/myCart',[CartsController::class,'showCart'])->name('myCart');
Route::middleware('auth')->post('/cart/add-quantity/{cartItemId}', [CartsController::class, 'addQuantity'])->name('cart.addQuantity');
Route::middleware('auth')->post('/cart/lose-quantity/{cartItemId}', [CartsController::class, 'loseQuantity'])->name('cart.loseQuantity');
Route::middleware('auth')->post('/cart/clear', [CartsController::class, 'clearCart'])->name('cart.clear');

