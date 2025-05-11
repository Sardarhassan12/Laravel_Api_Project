<?php

use App\Http\Controllers\TaskManagement\TaskController;
use App\Http\Controllers\Auth\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//User Related Routes
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){

    Route::post('/logout', [UserController::class, 'logout']);

    Route::controller(TaskController::class)->group(function(){
        Route::post('task/add', 'add');
        Route::get('task/list', 'list');
        Route::patch('task/edit/{id}', 'edit');
        Route::delete('task/destroy/{id}','destroy');
    });
    
});






//-----------------------------------------------------------------//
// Route::middleware('auth:sanctum')->group(function () {

//     // Logout route
//     Route::post('/logout', [UserController::class, 'logout']);

//     // Grouped Task routes
//     Route::prefix('tasks')->controller(TaskController::class)->group(function () {
//         Route::post('/add', 'add');
//         Route::get('/list', 'list');
//         Route::patch('/edit/{id}', 'edit');
//         Route::delete('/delete/{id}', 'delete'); // optional
//         Route::get('/show/{id}', 'show');        // optional
//     });
// });

//------------------------------------------------------------------------------------------//
// Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

// //Task Related Routes
// Route::post('/add', [TaskController::class, 'add'])->middleware('auth:sanctum');
// Route::get('/list', [TaskController::class, 'list'])->middleware('auth:sanctum');
// Route::patch('/edit/{id}', [TaskController::class, 'edit'])->middleware('auth:sanctum');