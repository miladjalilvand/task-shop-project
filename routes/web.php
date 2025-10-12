<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/dashboard', function(){
    return redirect('/dashboard/orders');   
})->middleware(['auth','role'])->name('dashboard');

Route::middleware(['auth', 'role'])->get('dashboard/users',[UserController::class , 'index'])->name('dashboard.users.index');
Route::middleware(['auth', 'role'])->patch('users/{user}/role', [UserController::class, 'updateRole'])->name('users.update-role');

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/product/{slug}', [ShopController::class, 'show'])->name('shop.show');