<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//User Related Routes
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

//Task Related Routes
Route::post('/add', [TaskController::class, 'add'])->middleware('auth:sanctum');
Route::get('/list', [TaskController::class, 'list'])->middleware('auth:sanctum');
Route::patch('/edit/{id}', [TaskController::class, 'edit'])->middleware('auth:sanctum');