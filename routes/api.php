<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Items
Route::apiResource('/items', \App\Http\Controllers\ItemController::class);
Route::apiResource('/limits', \App\Http\Controllers\UserItemLimitController::class);
Route::apiResource('/devices', \App\Http\Controllers\DeviceManagementController::class);
Route::delete('/devices/{device}/{itemId}', [\App\Http\Controllers\DeviceManagementController::class, 'destroy']);
Route::apiResource('/devices', \App\Http\Controllers\DeviceManagementController::class);
Route::post('/vending', [\App\Http\Controllers\VendingController::class, 'vending']);
Route::get('/vending', [\App\Http\Controllers\VendingController::class, 'index']);