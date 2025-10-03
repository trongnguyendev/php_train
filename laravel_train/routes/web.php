<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ImportReceiptController;
use App\Http\Controllers\WarehousesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\SaleNameController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\TypeCustomerController;
use App\Http\Controllers\TypeShowroomController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerStatisticsController;
use App\Http\Controllers\LeadOnlineController;

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

Route::resource('leadonline', LeadOnlineController::class);

// Importreceipts CRUD routes
Route::resource('importreceipts', ImportReceiptController::class);

// Warehouses CRUD routes
Route::resource('warehouses', WarehousesController::class);

Route::get('/customers/report', [CustomerController::class, 'report'])->name('customers.report');
Route::middleware(['auth'])->group(function () {
    Route::resource('users', UserController::class);
});

Route::resource('province', ProvinceController::class);

Route::resource('salename', SaleNameController::class);

Route::resource('status', StatusController::class);

Route::resource('source', SourceController::class);

Route::resource('type_customer', TypeCustomerController::class);

Route::resource('type_showroom', TypeShowroomController::class);

Route::resource('category', CategoryController::class);


Route::get('/statistics', [CustomerStatisticsController::class, 'index'])->name('statistics.index');
Route::get('/statistics/data', [CustomerStatisticsController::class, 'statisticsData'])->name('statistics.data');

