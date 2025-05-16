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
        Route::post('task/add', 'add')->middleware('permission:create task');
        Route::get('task/list', 'list')->middleware('permission:view task');
        Route::patch('task/edit/{id}', 'edit')->middleware('permission:update task');
        Route::delete('task/destroy/{id}','destroy')->middleware('permission:delete task');
        Route::post('/task/import', 'import')->middleware('permission:import task');
        Route::get('/task/export', 'export')->middleware('permission:export task');
        Route::get('/task/pdf','generatePDF')->middleware('permission:generate pdf');
    });
    
    
});
