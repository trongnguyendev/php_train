<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShowroomController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\CustomerStatusController;
use App\Http\Controllers\SaleUserController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\CustomerSourceController;
use App\Http\Controllers\CustomerTypeController;


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function (){
    if(auth()->check()) {
        return redirect()->route('users.index');
    }
    return redirect()->route('login');
});

Route::resource('showrooms', ShowroomController::class);
Route::resource('users', UserController::class);
Route::resource('product_categories', ProductCategoryController::class);
Route::resource('customer_status', CustomerStatusController::class);
Route::resource('sale_users', SaleUserController::class);
Route::resource('leads', LeadController::class);
Route::resource('customer_sources', CustomerSourceController::class);
Route::resource('customer_types', CustomerTypeController::class);
