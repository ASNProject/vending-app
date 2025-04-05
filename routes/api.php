<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Items
Route::apiResource('/items', \App\Http\Controllers\ItemController::class);
Route::apiResource('/limits', \App\Http\Controllers\UserItemLimitController::class);