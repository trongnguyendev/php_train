<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ImportReceiptController;
use App\Http\Controllers\WarehousesController;

Route::get('/', function () {
    return redirect()->route('users.index');
});

// User CRUD routes
Route::resource('users', UserController::class);

// Product CRUD routes
Route::resource('products', ProductController::class);

// Customer CRUD routes
Route::resource('customer', CustomerController::class);


// Importreceipts CRUD routes
Route::resource('importreceipts', ImportReceiptController::class);

// Warehouses CRUD routes
Route::resource('warehouses', WarehousesController::class);

Route::get('/customers/report', [CustomerController::class, 'report'])->name('customers.report');
