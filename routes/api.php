<?php

use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::resource('/users', UsersController::class);
Route::post('/users/login', [UsersController::class, 'login']);
Route::resource('/tasks', TaskController::class)->middleware('auth:sanctum');