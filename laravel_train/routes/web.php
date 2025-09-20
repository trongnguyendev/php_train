<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ImportReceiptController;
use App\Http\Controllers\WarehousesController;
use App\Http\Controllers\AuthController;

// Routes không cần đăng nhập
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('users.index');
    }
    return redirect()->route('login');
});

// Product CRUD routes
Route::resource('products', ProductController::class);

// Customer CRUD routes
Route::resource('customer', CustomerController::class);


// Importreceipts CRUD routes
Route::resource('importreceipts', ImportReceiptController::class);

// Warehouses CRUD routes
Route::resource('warehouses', WarehousesController::class);

Route::get('/customers/report', [CustomerController::class, 'report'])->name('customers.report');
Route::middleware(['auth'])->group(function () {
    Route::resource('users', UserController::class);
});