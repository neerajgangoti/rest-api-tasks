<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TaskController;  
  
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
    Route::post('/me', [AuthController::class, 'me'])->middleware('auth:api')->name('me');
    
});
/*
  Rest APIS for tasks
*/ 
Route::prefix('tasks')->group(function () {
    Route::post('/add', [TaskController::class, 'submitTask']);
    Route::get('/{task_id}/status', [TaskController::class, 'fetchTaskStatus']);
    Route::get('/{task_id}/result', [TaskController::class, 'fetchTaskResult']); 
});
