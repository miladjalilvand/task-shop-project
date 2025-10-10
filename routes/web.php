<?php

use App\Http\Controllers\AuthController;
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
    return view('dashboard');   
})->middleware(['auth','role'])->name('dashboard');

Route::get('dashboard/users',[UserController::class , 'index'])->name('dashboard.users.index');
Route::patch('users/{user}/role', [UserController::class, 'updateRole'])->name('users.update-role');

