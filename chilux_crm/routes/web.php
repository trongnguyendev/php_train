<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShowroomController;

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