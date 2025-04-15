<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserItemLimitController;
use App\Http\Controllers\VendingController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\DeviceController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'login'])->name('login.post');
Route::get('registration', [AuthController::class, 'register'])->name('register');
Route::post('post-registration', [AuthController::class, 'registerUser'])->name('register.post');
Route::middleware(['auth'])->get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->get('/home', [DashboardController::class, 'home'])->name('dashboard.home');
Route::middleware(['auth'])->get('/userdata', [DashboardController::class, 'userdata'])->name('dashboard.userdata');
Route::middleware(['auth'])->get('/nama-item', [DashboardController::class, 'namaItem'])->name('dashboard.nama-item');
Route::middleware(['auth'])->get('/atur-item', [DashboardController::class, 'aturItem'])->name('dashboard.atur-item');
Route::middleware(['auth'])->get('/data-pengguna', [DashboardController::class, 'dataPengguna'])->name('dashboard.data-pengguna');
Route::middleware(['auth'])->get('/record', [DashboardController::class, 'record'])->name('dashboard.record');

Route::resource('user-item-limits', UserItemLimitController::class);
Route::resource('item', ItemController::class);