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
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function (){
    if(auth()->check()) {
        return redirect()->route('users.index');
    }
    return redirect()->route('login');
})->name('dashboard');

Route::resource('showrooms', ShowroomController::class);
Route::resource('users', UserController::class);
Route::resource('product_categories', ProductCategoryController::class);
Route::resource('customer_status', CustomerStatusController::class);
Route::resource('sale_users', SaleUserController::class);
Route::resource('leads', LeadController::class);
Route::resource('customer_sources', CustomerSourceController::class);
Route::resource('customer_types', CustomerTypeController::class);
Route::resource('provinces', ProvinceController::class);

// Role and Permission routes
Route::resource('roles', RoleController::class);
Route::resource('permissions', PermissionController::class)->only(['index', 'show']);

// User role assignment routes
Route::get('users/{user}/assign-roles', [UserController::class, 'assignRoles'])->name('users.assign-roles');
Route::put('users/{user}/sync-roles', [UserController::class, 'syncRoles'])->name('users.sync-roles');
