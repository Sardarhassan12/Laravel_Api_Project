<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\TaskManagement\TaskController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->middleware(['signed'])->name('verification.verify');

Route::middleware('auth:sanctum', 'verified')->group(function(){

    Route::post('/logout', [AuthController::class, 'logout']);

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